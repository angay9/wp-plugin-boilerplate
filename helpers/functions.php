<?php

if (! function_exists('pb_render')) {
    function pb_render($view, array $args = []) {
        ob_start();
        extract($args);       

        $file_path = pb_get_view_path($view);

        if (! $file_path) {
            return '';
        }

        require $file_path;

        return ob_get_clean();
    }
}

if (! function_exists('pb_get_view_path')) {
    function pb_get_view_path($view) {
        $file_path = __DIR__ . '/../views/' . ltrim($view, '/');
 
        if (! file_exists($file_path)) {
            return '';
        }

        return $file_path;
    }
}


if (! function_exists('pb_array_get')) {
    /**
     * Get an item from an array using "dot" notation.
     *
     * @param  array $array
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    function pb_array_get($array, $key, $default = null)
    {
        if (is_null($key)) {
            return $array;
        }

        if (isset($array[$key])) {
            return $array[$key];
        }

        foreach (explode('.', $key) as $segment) {
            if (!is_array($array) || !array_key_exists($segment, $array)) {
                return $default;
            }

            $array = $array[$segment];
        }

        return $array;
    }
}

if (! function_exists('pb_config')) {
    function pb_config($key, $default = null) {
        $config_path = __DIR__ . '/../config/config.php';
        $theme_config_path = get_stylesheet_directory() . '/plugin-boilerplate/config/config.php';

        $config = require $config_path;
        $theme_config = [];

        if (file_exists($theme_config_path)) {
            $theme_config = require $theme_config_path; 
        }

        $config = array_merge($config, $theme_config);

        return pb_array_get($config, $key, $default);
    }
}