# laravel-multiuser-json-settings
Simple user settings facade for Laravel 4. Settings are stored as JSON in a single database column, so you can easily add it to an existing table (`users` for example).


## Installation
1. Begin by installing this package through Composer. Edit your project's composer.json file to require cmarfil/laravel-multiuser-json-settings.
```
"require": {
    "cmarfil/laravel-multiuser-json-settings": "1.1.*"
}
```
2. Add `'Cmarfil\LaravelMultiUserJsonSettings\ServiceProvider'` to `providers` in `app/config/app.php`.

  ```php
  'providers' => array(
    // ...
    'Cmarfil\LaravelMultiUserJsonSettings\ServiceProvider',
  ),
  ```
3. Add `'Setting' => 'Cmarfil\LaravelMultiUserJsonSettings\Facade'` to `aliases` in `app/config/app.php`.

  ```php
  'aliases' => array(
    // ...
    'Setting' => 'Cmarfil\LaravelMultiUserJsonSettings\Facade',
  ),
  ```

4. Run `php artisan config:publish cmarfil/laravel-multiuser-json-settings` to publish the config file.
5. Modify the published configuration file located at `app/config/packages/cmarfil/laravel-multiuser-json-settings/config.php` to your liking.
6. Create a varchar (string) column in a table on your database to match the config file in step 5. Alternatively, use the Laravel migration included in this package to automatically create a `settings` column in the `users` table: `php artisan migrate --package=cmarfil/laravel-multiuser-json-settings`.


## Configuration
Pop open `app/config/packages/cmarfil/laravel-multiuser-json-settings/config.php` to adjust package configuration. If this file doesn't exist, run `php artisan config:publish cmarfil/laravel-multiuser-json-settings` to create the default configuration file.

```php
return array(
    'table' => 'users',
    'column' => 'settings',
	'constraint_key' => 'id',
	'default_constraint_value' => (Auth::check() ? Auth::id() : null)
	'custom_constraint' => false, //'id = ' . (Auth::check() ? Auth::id() : null),
);
```

#### Table
Specify the table on your database that you want to use.

#### Column
Specify the column in the above table that you want to store the settings JSON data in.

#### Constraint key
Specify the column constraint - this is used to differentiate between different users, objects or models ( normally id ).

#### Default constraint value
Specify the default constraint value - If you do not specify one, default configuration is obtained, in this case the user logged.

#### Custom constraint
Specify a where clause for each query - Caution: Leave blank if your want to set or get different rows on same runtime, use constraint_key and default_constraint_value

## Usage
Use the Setting facade (`Setting::`) to access the functions in this package.

#### Set
```php
Setting::set('key', 'value', $constraint_value);
```
Use `set` to change the value of a setting. If the setting does not exist, it will be created automatically. You can set multiple keys at once by passing an associative (key=>value) array to the first parameter.
If you do not pass constraint_value the value used by default is default_constraint_value

#### Get
```php
Setting::get('key', 'default', $constraint_value);
```
Use `get` to retrieve the value of a setting. The second parameter is optional and can be used to specify a default value if the setting does not exist (the default default value is `null`).
If you do not pass constraint_value the value used by default is default_constraint_value

#### Forget
```php
Setting::forget('key', $constraint_value);
```
Unset or delete a setting by calling `forget`.
If you do not pass constraint_value the value used by default is default_constraint_value

#### Has
```php
Setting::has('key', $constraint_value);
```
Check for the existence of a setting, returned as a boolean.
If you do not pass constraint_value the value used by default is default_constraint_value

#### All
```php
Setting::all($constraint_value);
```
Retrieve all settings as an associative array (key=>value).
If you do not pass constraint_value the value used by default is default_constraint_value

#### Save
```php
Setting::save($constraint_value);
```
Save all changes back to the database. This will need to be called after making changes; it is not automatic.
If you do not pass constraint_value the value used by default is default_constraint_value

#### Load
```php
Setting::load($constraint_value);
```
Reload settings from the database. This is called automatically if settings have not been loaded before being accessed or mutated.
If you do not pass constraint_value the value used by default is default_constraint_value

##Example
With default configuration:
```php
return array(
    'table' => 'users',
    'column' => 'settings',
	'constraint_key' => 'id',
	'default_constraint_value' => (Auth::check() ? Auth::id() : null)
	'custom_constraint' => false, //'id = ' . (Auth::check() ? Auth::id() : null),
);
```

The following set and returns the **user logged** setting "email_notification"
```php
//Set email_notifications setting to false
Setting::set('email_notifications', false);

//Save config
Setting::save();

//Save email_notifications
return Setting::get('email_notifications');
```

The following set and returns the setting "email_notification" for **user with id 23**
```php
//Set email_notifications setting to false
Setting::set('email_notifications', false, 23);

//Save config
Setting::save(23);

//Save email_notifications
return Setting::get('email_notifications', true, 23);
```


## Finally

#### Contributing
Feel free to create a fork and submit a pull request if you would like to contribute.

#### Bug reports
Raise an issue on GitHub if you notice something broken.

#### Credits
Fork of https://github.com/Grimthorr/laravel-user-settings.
Based loosely on https://github.com/anlutro/laravel-settings.
