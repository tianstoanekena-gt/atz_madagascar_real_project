<?php

if (!function_exists('localized_route')) {
    function localized_route($name, $parameters = [])
    {
        return route($name, array_merge(['locale' => app()->getLocale()], $parameters));
    }
}
