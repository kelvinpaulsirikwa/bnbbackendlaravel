<?php

namespace App\Support\Concerns;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait ResolvesImageUrls
{
    protected function resolveImageUrl(?string $path): string
    {
        if (empty($path)) {
            return $this->defaultImageUrl();
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        $normalized = ltrim($path, '/');

        if (Str::startsWith($normalized, ['storage/', 'images/', 'assets/', 'uploads/', 'public/'])) {
            $publicPath = public_path($normalized);

            if (file_exists($publicPath)) {
                return asset($normalized);
            }
        }

        if (Storage::disk('public')->exists($path)) {
            return Storage::url($path);
        }

        if (Storage::exists($path)) {
            return Storage::url($path);
        }

        if (Storage::disk('public')->exists($normalized)) {
            return Storage::url($normalized);
        }

        if (file_exists(public_path($normalized))) {
            return asset($normalized);
        }

        return $this->defaultImageUrl();
    }

    protected function defaultImageUrl(): string
    {
        return asset('images/noimage.png');
    }
}

