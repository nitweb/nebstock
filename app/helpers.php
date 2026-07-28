<?php

use App\Models\SiteSettings;

if (!function_exists('GlobalSiteSettings')) {
    function GlobalSiteSettings()
    {
        $site_settings_info = SiteSettings::find(1);
        return $site_settings_info;
    }
}