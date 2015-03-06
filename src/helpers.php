<?php

if (!function_exists('setting'))
{
    /**
     * Helper function for Setting facade.
     *
     * @param string $key
     * @param mixed $default
     * @param string $constraint_value
     * @return mixed
     */
    function setting($key = null, $default = null, $constraint_value = null)
    {
        $instance = app('setting');

        if (!isset($instance)) {
            $instance = app()->make('Grimthorr\LaravelUserSettings\Setting');
        }

        if (isset($key)) {
            return $instance->get($key, $default, $constraint_value);
        }

        return app('setting');
    }
}
