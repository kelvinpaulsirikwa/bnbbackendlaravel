<?php

namespace App\Http\Middleware;

use App\Models\AdminLog;
use App\Support\AdminLogMeta;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LogAdminActivity
{
    private const SANITIZE_KEYS = ['password', 'password_confirmation', '_token', 'current_password'];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $user = Auth::user();
        if (!$user || $user->role !== 'bnbadmin') {
            return $response;
        }

        // Only log create/update/delete (skip GET to save space)
        if (strtoupper($request->method()) === 'GET') {
            return $response;
        }

        $this->log($request, $user->id);

        return $response;
    }

    protected function log(Request $request, int $adminUserId): void
    {
        $route = $request->route();
        $routeName = $route ? $route->getName() : null;
        $action = $this->buildActionDescription($request->method(), $routeName, $request->path());

        $requestData = $this->sanitizeRequest($request);

        $description = AdminLogMeta::getDescription($request)
            ?? $this->buildDefaultDescription($request->method(), $routeName, $request);

        $payload = [
            'admin_user_id' => $adminUserId,
            'action' => $action,
            'method' => $request->method(),
            'route_name' => $routeName,
            'url' => $request->fullUrl(),
            'description' => $description,
            'subject_type' => AdminLogMeta::getSubjectType($request),
            'subject_id' => AdminLogMeta::getSubjectId($request),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'request_data' => $requestData,
            'old_values' => AdminLogMeta::getOldValues($request),
            'new_values' => AdminLogMeta::getNewValues($request) ?? $this->newValuesFromRequestData($request->method(), $requestData),
        ];

        AdminLog::create(array_filter($payload, fn ($v) => $v !== null));
    }

    protected function buildDefaultDescription(string $method, ?string $routeName, Request $request): string
    {
        if (!$routeName) {
            return $method . ' ' . $request->path();
        }
        $parts = explode('.', $routeName);
        $resource = $parts[1] ?? null;
        $verb = $parts[2] ?? null;
        if (!$resource) {
            return $method . ' ' . $routeName;
        }
        $resourceLabel = str_replace(['-', '_'], ' ', $resource);
        $resourceLabel = ucfirst($resourceLabel);
        if ($verb === 'store' || ($method === 'POST' && $verb === null)) {
            return "Created {$resourceLabel}";
        }
        if ($verb === 'update' || $verb === 'destroy' || in_array($method, ['PUT', 'PATCH', 'DELETE'], true)) {
            if ($verb === 'destroy' || $method === 'DELETE') {
                return "Deleted {$resourceLabel}";
            }
            return "Updated {$resourceLabel}";
        }
        if (in_array($verb, ['index', 'create', 'edit', 'show'], true)) {
            return "Viewed {$resourceLabel}";
        }
        return $method . ' ' . $routeName;
    }

    protected function newValuesFromRequestData(string $method, ?array $requestData): ?array
    {
        if ($requestData === null || $requestData === [] || $method === 'GET') {
            return null;
        }
        return $requestData;
    }

    protected function buildActionDescription(string $method, ?string $routeName, string $path): string
    {
        if ($routeName) {
            return "{$method} {$routeName}";
        }
        return "{$method} {$path}";
    }

    protected function sanitizeRequest(Request $request): ?array
    {
        $all = $request->except(self::SANITIZE_KEYS);
        if (empty($all)) {
            return null;
        }
        $filtered = [];
        foreach ($all as $key => $value) {
            if (in_array(strtolower($key), array_map('strtolower', self::SANITIZE_KEYS), true)) {
                continue;
            }
            if (is_string($value) && strlen($value) > 1000) {
                $value = '[truncated]';
            }
            $filtered[$key] = $value;
        }
        return $filtered ?: null;
    }
}
