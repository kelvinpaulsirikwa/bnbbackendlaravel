<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminLog extends Model
{
    use HasFactory;

    protected $table = 'admin_logs';

    protected $fillable = [
        'admin_user_id',
        'action',
        'method',
        'route_name',
        'url',
        'subject_type',
        'subject_id',
        'description',
        'ip_address',
        'user_agent',
        'request_data',
        'old_values',
        'new_values',
    ];

    protected $casts = [
        'request_data' => 'array',
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    /**
     * Parse user_agent to get browser and platform (OS) name.
     */
    public function getBrowserAttribute(): string
    {
        return $this->parseUserAgent()['browser'];
    }

    /**
     * Parse user_agent to get platform (OS) name.
     */
    public function getPlatformAttribute(): string
    {
        return $this->parseUserAgent()['platform'];
    }

    protected function parseUserAgent(): array
    {
        $ua = $this->user_agent ?? '';
        $browser = 'Unknown';
        $platform = 'Unknown';

        if (preg_match('/MSIE|Trident/i', $ua)) {
            $browser = 'Internet Explorer';
        } elseif (preg_match('/Edg/i', $ua)) {
            $browser = 'Edge';
        } elseif (preg_match('/Chrome/i', $ua) && !preg_match('/Chromium|Edg/i', $ua)) {
            $browser = 'Chrome';
        } elseif (preg_match('/Safari/i', $ua) && !preg_match('/Chrome/i', $ua)) {
            $browser = 'Safari';
        } elseif (preg_match('/Firefox/i', $ua)) {
            $browser = 'Firefox';
        } elseif (preg_match('/Opera|OPR/i', $ua)) {
            $browser = 'Opera';
        }

        if (preg_match('/Windows/i', $ua)) {
            $platform = 'Windows';
        } elseif (preg_match('/Mac OS X|Macintosh/i', $ua)) {
            $platform = 'macOS';
        } elseif (preg_match('/Linux/i', $ua)) {
            $platform = 'Linux';
        } elseif (preg_match('/Android/i', $ua)) {
            $platform = 'Android';
        } elseif (preg_match('/iPhone|iPad|iPod/i', $ua)) {
            $platform = 'iOS';
        }

        return ['browser' => $browser, 'platform' => $platform];
    }

    public function adminUser(): BelongsTo
    {
        return $this->belongsTo(BnbUser::class, 'admin_user_id');
    }
}
