<?php

use App\Models\Setting;


function locale_route(string $name, array $parameters = []): string
{
    return route($name, array_merge(['locale' => app()->getLocale()], $parameters));
}


if (!function_exists('setting')) {
    /**
     * Récupère une valeur de paramètre global
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function setting(string $key, $default = null)
    {
        return Setting::getValue($key, $default);
    }
}
