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
     * The constraint (SQL where clause).
     * Configured by the developer (see config/config.php for default).
     *
     * @var string
     */
    protected $constraint = '';

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
     *
     * @var array
     */
    protected $loaded = false;


    /**
     * Construction method to read package configuration.
     * 
     * @return void
     */
    public function __construct()
    {
        $this->table = \Config::get('grimthorr/laravel-user-settings::table');
        $this->column = \Config::get('grimthorr/laravel-user-settings::column');
        $this->constraint = \Config::get('grimthorr/laravel-user-settings::constraint');
    }


    /**
     * Get the value of a specific setting.
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        $this->check();

        return array_get($this->settings, $key, $default);
    }

    /**
     * Set the value of a specific setting.
     * 
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value = null)
    {
        $this->check();

        $this->dirty = true;

        if (is_array($key)) {
            foreach ($key as $k => $v) {
                array_set($this->settings, $k, $v);
            }
        } else {
            array_set($this->settings, $key, $value);
        }
    }

    /**
     * Unset a specific setting.
     * 
     * @param string $key
     * @return void
     */
    public function forget($key)
    {
        $this->check();

        if (array_key_exists($key, $this->settings)) {
            unset($this->settings[$key]);

            $this->dirty = true;
        }
    }

    /**
     * Check for the existance of a specific setting.
     * 
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        $this->check();

        return array_key_exists($key, $this->settings);
    }

    /**
     * Return the entire settings array.
     * 
     * @return array
     */
    public function all()
    {
        $this->check();

        return $this->settings;
    }

    /**
     * Save all changes back to the database.
     * 
     * @return void
     */
    public function save()
    {
        if ($this->dirty) {
            $json = json_encode($this->settings);
            
            $update = array();
            $update[$this->column] = $json;

            $res = \DB::table($this->table)
                ->whereRaw($this->constraint)
                ->update($update);

            $this->dirty = false;
        }

        $this->loaded = true;
    }

    /**
     * Load settings from the database.
     * 
     * @return void
     */
    public function load()
    {
        $json = \DB::table($this->table)
                ->whereRaw($this->constraint)
                ->pluck($this->column);
                //->first();

        $this->settings = json_decode($json, true);

        $this->dirty = false;
        $this->loaded = true;
    }


    /**
     * Check if settings have been loaded, load if not.
     * 
     * @return void
     */
    protected function check()
    {
        if (!$this->loaded) {
            $this->load();
            $this->loaded = true;
        }
    }

}
