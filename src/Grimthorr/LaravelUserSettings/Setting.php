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
     * The constraint value (the value to use with the above key).
     * Configured by the developer (see config/config.php for default).
     *
     * @var string
     */
    protected $constraint_value = '';

    /**
     * The settings cache.
     *
     * @var array
     */
    protected $settings = array();

    /**
     * Whether any settings have been modified since being loaded.
     *
     * @var bool
     */
    protected $dirty = false;

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
        $this->table = \Config::get('grimthorr/laravel-user-settings::table');
        $this->column = \Config::get('grimthorr/laravel-user-settings::column');
        $this->custom_constraint = \Config::get('grimthorr/laravel-user-settings::custom_constraint');
		$this->constraint_key = \Config::get('grimthorr/laravel-user-settings::constraint_key');
		$this->default_constraint_value = \Config::get('grimthorr/laravel-user-settings::default_constraint_value');
    }


    /**
     * Get the value of a specific setting.
     *
     * @param string $key
     * @param mixed $default
     * @param string $custom_constraint_value
     * @return mixed
     */
    public function get($key, $default = null, $custom_constraint_value = null)
    {
		$constraint_value = $this->negotiate_constraint_value($custom_constraint_value);
        $this->check($constraint_value);

        return array_get($this->settings[$constraint_value], $key, $default);
    }

    /**
     * Set the value of a specific setting.
     *
     * @param string $key
     * @param mixed $value
	 * @param string $custom_constraint_value
     * @return void
     */
    public function set($key, $value = null, $custom_constraint_value = null)
    {
		$constraint_value = $this->negotiate_constraint_value($custom_constraint_value);
        $this->check($constraint_value);

        $this->dirty = true;

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
	 * @param string $custom_constraint_value
     * @return void
     */
    public function forget($key, $custom_constraint_value = null)
    {
		$constraint_value = $this->negotiate_constraint_value($custom_constraint_value);
        $this->check($constraint_value);

        if (array_key_exists($key, $this->settings[$constraint_value])) {
            unset($this->settings[$constraint_value]);

            $this->dirty = true;
        }
    }

    /**
     * Check for the existence of a specific setting.
     *
     * @param string $key
     * @param string $custom_constraint_value
     * @return bool
     */
    public function has($key, $custom_constraint_value = null)
    {
		$constraint_value = $this->negotiate_constraint_value($custom_constraint_value);
        $this->check($constraint_value);

        return array_key_exists($constraint_value, $this->settings) ?: array_key_exists($key, $this->settings[$constraint_value]);
    }

    /**
     * Return the entire settings array.
     *
	 * @param string $custom_constraint_value
     * @return array
     */
    public function all($custom_constraint_value = null)
    {
		$constraint_value = $this->negotiate_constraint_value($custom_constraint_value);
        $this->check($constraint_value);

        return $this->settings[$constraint_value];
    }

    /**
     * Save all changes back to the database.
     *
	 * @param string $custom_constraint_value
     * @return void
     */
    public function save($custom_constraint_value = null)
    {
		$constraint_value = $this->negotiate_constraint_value($custom_constraint_value);

        if ($this->dirty) {
            $json = json_encode($this->settings[$constraint_value]);

            $update = array();
            $update[$this->column] = $json;

			$constraint_query = $this->negotiate_constraint_query($constraint_value);

            $res = \DB::table($this->table)
                ->whereRaw($constraint_query)
                ->update($update);

            $this->dirty = false;
        }

        $this->loaded[$constraint_value] = true;
    }

    /**
     * Load settings from the database.
	 *
     * @param string $custom_constraint_value
     * @return void
     */
    public function load($custom_constraint_value = null)
    {
		$constraint_value = $this->negotiate_constraint_value($custom_constraint_value);
		$constraint_query = $this->negotiate_constraint_query($constraint_value);
        $json = \DB::table($this->table)
                ->whereRaw($constraint_query)
                ->pluck($this->column);
                //->first();

        $this->settings[$constraint_value] = json_decode($json, true);

        $this->dirty = false;
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
     * Negotiate constraint value; use custom if specified or default.
	 *
     * @param string $constraint_value
     * @return mixed
     */
	public function negotiate_constraint_value($constraint_value)
    {
		return $constraint_value ?: $this->default_constraint_value;
	}

    /**
     * Negotiate constraint query.
	 *
     * @param string $constraint_value
     * @return mixed
     */
	public function negotiate_constraint_query($constraint_value)
    {
		return $this->custom_constraint ?: $this->constraint_key . ' = ' . $constraint_value;
	}

}
