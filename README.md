# laravel-user-settings
Simple user settings facade for Laravel 4. Settings are stored as JSON in a single database column, so you can easily add it to an existing table (`users` for example).


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
5. Modify the published configuration file located at `app/config/packages/grimthorr/laravel-user-settings/config.php` to your liking.
6. Create a varchar (string) column in a table on your database to match the config file in step 5. Alternatively, use the Laravel migration included in this package to automatically create a `settings` column in the `users` table: `php artisan migrate --package=grimthorr/laravel-user-settings`.


## Configuration
Pop open `app/config/packages/grimthorr/laravel-user-settings/config.php` to adjust package configuration. If this file doesn't exist, run `php artisan config:publish grimthorr/laravel-user-settings` to create the default configuration file.

```php
return array(
    'table' => 'users',
    'column' => 'settings',
    'constraint' => 'id = ' . (Auth::check() ? Auth::id() : null),
);
```

#### Table
Specify the table on your database that you want to use.

#### Column
Specify the column in the above table that you want to store the settings JSON data in.

#### Constraint
Specify a where clause for each query - this is used to differentiate between different users, objects or models. For example: if you're using the `users` table, each user will have a unique `id`. Caution: do not leave this blank if you intend to store multiple rows in the selected table.


## Usage
Use the Setting facade (`Setting::`) to access the functions in this package.

#### Set
```php
Setting::set('key', 'value');
```
Use `set` to change the value of a setting. If the setting does not exist, it will be created automatically. You can set multiple keys at once by passing an associative (key=>value) array to the first parameter.

#### Get
```php
Setting::get('key', 'default');
```
Use `get` to retrieve the value of a setting. The second parameter is optional and can be used to specify a default value if the setting does not exist (the default default value is `null`).

#### Forget
```php
Setting::forget('key');
```
Unset or delete a setting by calling `forget`.

#### Has
```php
Setting::has('key');
```
Check for the existence of a setting, returned as a boolean.

#### All
```php
Setting::all();
```
Retrieve all settings as an associative array (key=>value).

#### Save
```php
Setting::save();
```
Save all changes back to the database. This will need to be called after making changes; it is not automatic.

#### Load
```php
Setting::load();
```
Reload settings from the database. This is called automatically if settings have not been loaded before being accessed or mutated.


## Finally

#### Contributing
Feel free to create a fork and submit a pull request if you would like to contribute.

#### Bug reports
Raise an issue on GitHub if you notice something broken.

#### Credits
Based loosely on https://github.com/anlutro/laravel-settings.
