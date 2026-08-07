<?php

use App\Models\SiteSettings;

if (!function_exists('GlobalSiteSettings')) {
    function GlobalSiteSettings()
    {
        $site_settings_info = SiteSettings::find(1);
        return $site_settings_info;
    }
}

if (!function_exists('GlobalCategories')) {
    function GlobalCategories()
    {
        return \App\Models\Category::active()->root()->orderBy('sort_order')->take(5)->get();
    }
}
