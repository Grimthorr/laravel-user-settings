# laravel-user-settings
Simple user settings facade for Laravel 4. Settings are stored as JSON in a single column on your database, so you can easily add it to a `users` table for instance.


## Installation
1. Run `composer require grimthorr/laravel-user-settings` to include this in your project.
2. Add `'Grimthorr\LaravelUserSettings\ServiceProvider'` to `providers` in `app/config/app.php`.

  ```php
  'providers' => array(
    // ...
    'Grimthorr\LaravelUserSettings\ServiceProvider',
  ),
  ```
3. Add `'Setting' => 'Grimthorr\LaravelUserSettings\Facade'` to `aliases` in `app/config/app.php`.
  
  ```php
  'aliases' => array(
    // ...
    'Setting' => 'Grimthorr\LaravelUserSettings\Facade',
  ),
  ```

4. Run `php artisan config:publish grimthorr/laravel-user-settings` to publish the config file.
5. Create a varchar column in the table of your choice. This column will be used to store the settings data. Alternatively, use the migration provided to create a `settings` column in the `users` table: `php artisan migrate --package=grimthorr/laravel-user-settings`.
6. Modify the configuration file published in `app/config/packages/grimthorr/laravel-user-settings/config.php` to your liking.


## Configuration
Pop open `app/config/packages/grimthorr/laravel-user-settings/config.php` to adjust package configuration.

```php
return array(
    'table' => 'users',
    'column' => 'settings',
    'constraint' => 'id = ' . Auth::user()->id,
);
```

#### Table
Specify the database table that you want to use.

#### Column
Specify the column in the above table used to store the settings JSON data; the package will only modify this column.

#### Constraint
Specify a where clause for each row - this is used to differentiate between different users. For example, if using the `users` table, each user will have a unique `id`. Caution: do not leave this blank if you have multiple users.


## Usage
Simply use the Setting facade to access this package.

#### Set
```php
Setting::set('key', 'value');
```
Use `set` to change the value of a setting. If the setting does not exist, it is created automatically. Set multiple keys at once by passing a `key=>value` array to the first parameter.

#### Get
```php
Setting::get('key', 'default');
```
Use `get` to call the value of a setting. The second parameter is optional and can be used to specify a default value if the key does not exist (the default default value is `null`).

#### Forget
```php
Setting::forget('key');
```
Unset a setting by calling `forget`.

#### Has
```php
Setting::has('key');
```
Check for the existance of a setting, returns boolean.

#### All
```php
Setting::all();
```
Pull the entire settings array.

#### Save
```php
Setting::save();
```
Save all changes - make sure to call this after making changes.

#### Load
```php
Setting::load();
```
Reload settings from the database - this is called automatically if settings have not be loaded before being accessed or mutated.


## Finally

#### Contributing
Feel free to create a fork and submit a pull request if you would like to contribute.

#### Bug reports
Raise an issue on GitHub if you notice something broken.

#### Credits
Based loosely on https://github.com/anlutro/laravel-settings.
