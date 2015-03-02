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
        $instance = app('Setting')->getFacadeRoot();

        if (isset($key)) {
            return $instance->get($key, $default, $constraint_value);
        }

        return app('Setting')->getFacadeRoot();
    }
}
