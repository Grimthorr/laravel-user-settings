<?php

namespace Grimthorr\LaravelUserSettings;


class Setting {

    /**
     * The table name.
     * Configured by the developer (see config/config.php for default).
     *
     * @var string
     */
    protected $table = '';

    /**
     * The column name.
     * Configured by the developer (see config/config.php for default).
     *
     * @var string
     */
    protected $column = '';

    /**
     * Custom constraint (SQL where clause).
     * Configured by the developer (see config/config.php for default).
     *
     * @var string
     */
    protected $custom_constraint = '';

    /**
     * The constraint key (table index used to specify the constraint).
     * Configured by the developer (see config/config.php for default).
     *
     * @var string
     */
    protected $constraint_key = '';

    /**
     * The default constraint value (used with the $constraint_key to generate a where clause).
     * This will only be used if $constraint_value is not specified.
     * Configured by the developer (see config/config.php for default).
     *
     * @var string
     */
    protected $default_constraint_value = '';

    /**
     * The settings cache.
     *
     * @var array
     */
    protected $settings = array();

    /**
     * Whether any settings have been modified since being loaded.
     * We use an array so different constraints can be flagged as dirty separately.
     *
     * @var bool
     */
    protected $dirty = array();

    /**
     * Whether settings have been loaded from the database (this session).
     * We use an array so different constraints can be loaded separately.
     *
     * @var array
     */
    protected $loaded = array();


    /**
     * Construction method to read package configuration.
     *
     * @return void
     */
    public function __construct()
    {
        $this->table = config('laravel-user-settings.table');
        $this->column = config('laravel-user-settings.column');
        $this->custom_constraint = config('laravel-user-settings.custom_constraint');
        $this->constraint_key = config('laravel-user-settings.constraint_key');
        $this->default_constraint_value = config('laravel-user-settings.default_constraint_value');

        if(is_null($this->default_constraint_value)) {
            $this->default_constraint_value = (\Auth::check() ? \Auth::id() : null);
        }
    }


    /**
     * Get the value of a specific setting.
     *
     * @param string $key
     * @param mixed $default
     * @param string $constraint_value
     * @return mixed
     */
    public function get($key, $default = null, $constraint_value = null)
    {
        $constraint_value = $this->getConstraintValue($constraint_value);
        $this->check($constraint_value);

        return array_get($this->settings[$constraint_value], $key, $default);
    }

    /**
     * Set the value of a specific setting.
     *
     * @param string $key
     * @param mixed $value
     * @param string $constraint_value
     * @return void
     */
    public function set($key, $value = null, $constraint_value = null)
    {
        $constraint_value = $this->getConstraintValue($constraint_value);
        $this->check($constraint_value);

        $this->dirty[$constraint_value] = true;

        if (is_array($key)) {
            foreach ($key as $k => $v) {
                array_set($this->settings[$constraint_value], $k, $v);
            }
        } else {
            array_set($this->settings[$constraint_value], $key, $value);
        }
    }

    /**
     * Unset a specific setting.
     *
     * @param string $key
     * @param string $constraint_value
     * @return void
     */
    public function forget($key, $constraint_value = null)
    {
        $constraint_value = $this->getConstraintValue($constraint_value);
        $this->check($constraint_value);

        if (array_key_exists($key, $this->settings[$constraint_value])) {
            unset($this->settings[$constraint_value][$key]);

            $this->dirty[$constraint_value] = true;
        }
    }

    /**
     * Check for the existence of a specific setting.
     *
     * @param string $key
     * @param string $constraint_value
     * @return bool
     */
    public function has($key, $constraint_value = null)
    {
        $constraint_value = $this->getConstraintValue($constraint_value);
        $this->check($constraint_value);

        if (!array_key_exists($constraint_value, $this->settings)) {
            return false;
        }

        return array_key_exists($key, $this->settings[$constraint_value]);
    }

    /**
     * Return the entire settings array.
     *
     * @param string $constraint_value
     * @return array
     */
    public function all($constraint_value = null)
    {
        $constraint_value = $this->getConstraintValue($constraint_value);
        $this->check($constraint_value);

        return $this->settings[$constraint_value];
    }

    /**
     * Save all changes back to the database.
     *
     * @param string $constraint_value
     * @return void
     */
    public function save($constraint_value = null)
    {
        $constraint_value = $this->getConstraintValue($constraint_value);
        $this->check($constraint_value);

        if ($this->dirty[$constraint_value]) {
            $json = json_encode($this->settings[$constraint_value]);

            $update = array();
            $update[$this->column] = $json;

            $constraint_query = $this->getConstraintQuery($constraint_value);

            $res = \DB::table($this->table)
                ->whereRaw($constraint_query)
                ->update($update);

            $this->dirty[$constraint_value] = false;
        }

        $this->loaded[$constraint_value] = true;
    }

    /**
     * Load settings from the database.
     *
     * @param string $constraint_value
     * @return void
     */
    public function load($constraint_value = null)
    {
        $constraint_value = $this->getConstraintValue($constraint_value);
        $constraint_query = $this->getConstraintQuery($constraint_value);
        $json = \DB::table($this->table)
            ->whereRaw($constraint_query)
            ->value($this->column);

        $this->settings[$constraint_value] = json_decode($json, true);

        $this->dirty[$constraint_value] = false;
        $this->loaded[$constraint_value] = true;
    }

    /**
     * Check if settings have been loaded, load if not.
     *
     * @param string $constraint_value
     * @return void
     */
    protected function check($constraint_value)
    {
        if (empty($this->loaded[$constraint_value])) {
            $this->load($constraint_value);
            $this->loaded[$constraint_value] = true;
        }
    }

    /**
     * Get constraint value; use custom if specified or default.
     *
     * @param string $constraint_value
     * @return mixed
     */
    protected function getConstraintValue($constraint_value)
    {
        return $constraint_value ?: $this->default_constraint_value;
    }

    /**
     * Get constraint query.
     *
     * @param string $constraint_value
     * @return mixed
     */
    protected function getConstraintQuery($constraint_value)
    {
        return $this->custom_constraint ?: $this->constraint_key . ' = ' . $constraint_value;
    }

}
