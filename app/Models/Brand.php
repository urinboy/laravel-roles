<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'name',
        'description',
        'logo', // optional: path to logo image
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getLogoUrlAttribute()
    {
        $appUrl = config('app.url');

        // 1. assets/logos/ dan boshlangan va mavjud bo'lsa.
        if ($this->logo && preg_match('/^(\/)?assets\/logos\/.+\.(png|jpe?g|svg)$/i', $this->logo)) {
            $relativePath = ltrim($this->logo, '/'); // oldidagi / ni olib tashlash
            $fullPath = public_path($relativePath);
            if (file_exists($fullPath)) {
                return $appUrl . '/' . $relativePath;
            }
        }

        // 2. brands/ dan boshlangan va storage/public/brands/ da mavjud bo'lsa.
        if ($this->logo && preg_match('/^(\/)?brands\/.+\.(png|jpe?g|svg)$/i', $this->logo)) {
            $relativePath = ltrim($this->logo, '/'); // oldidagi / ni olib tashlash
            $fullPath = public_path('storage/' . $relativePath);
            if (file_exists($fullPath)) {
                return $appUrl . '/storage/' . $relativePath;
            }
        }

        // 3. Default logo
        return $appUrl . '/assets/logos/default-logo.png';
    }

    // Brand.php
    public static function getUniversalLogoUrl($logo)
    {
        $appUrl = config('app.url');
        $logo = ltrim($logo, '/');

        // assets/logos/...
        if ($logo && preg_match('/^assets\/logos\/.+\.(png|jpe?g|svg)$/i', $logo)) {
            $fullPath = public_path($logo);
            if (file_exists($fullPath)) {
                return $appUrl . '/' . $logo;
            }
        }

        // brands/...
        if ($logo && preg_match('/^brands\/.+\.(png|jpe?g|svg)$/i', $logo)) {
            $fullPath = public_path('storage/' . $logo);
            if (file_exists($fullPath)) {
                return $appUrl . '/storage/' . $logo;
            }
        }

        // Default
        return $appUrl . '/assets/logos/default-logo.png';
    }
}
