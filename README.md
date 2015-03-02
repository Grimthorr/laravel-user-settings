# laravel-user-settings
Simple user settings facade for Laravel 5. Settings are stored as JSON in a single database column, so you can easily add it to an existing table (`users` for example).

**Still using Laravel 4?** Make sure to use [version 1.x](https://github.com/Grimthorr/laravel-user-settings/tree/laravel4) instead (`composer require grimthorr/laravel-user-settings ~1.0`).


## Installation
1. Run `composer require grimthorr/laravel-user-settings` to include this in your project.
2. Add `'Grimthorr\LaravelUserSettings\ServiceProvider'` to `providers` in `config/app.php`.

  ```php
  'providers' => array(
    // ...
    'Grimthorr\LaravelUserSettings\ServiceProvider',
  ),
  ```

3. Add `'Setting' => 'Grimthorr\LaravelUserSettings\Facade'` to `aliases` in `config/app.php`.

  ```php
  'aliases' => array(
    // ...
    'Setting' => 'Grimthorr\LaravelUserSettings\Facade',
  ),
  ```

4. Run `php artisan vendor:publish --provider="Grimthorr\LaravelUserSettings\ServiceProvider" --tag="config"` to publish the config file.
5. Modify the published configuration file located at `config/laravel-user-settings.php` to your liking.
6. Create a varchar (string) column in a table on your database to match the config file in step 5. Alternatively, use the Laravel migration included in this package to automatically create a `settings` column in the `users` table: `php artisan vendor:publish --provider="Grimthorr\LaravelUserSettings\ServiceProvider" --tag="migrations" && php artisan migrate`.


## Configuration
Pop open `config/laravel-user-settings.php` to adjust package configuration. If this file doesn't exist, run `php artisan vendor:publish --provider="Grimthorr\LaravelUserSettings\ServiceProvider" --tag="config"` to create the default configuration file.

```php
return array(
  'table' => 'users',
  'column' => 'settings',
  'constraint_key' => 'id',
  'default_constraint_value' => null,
  'custom_constraint' => null,
);
```

#### Table
Specify the table on your database that you want to use.

#### Column
Specify the column in the above table that you want to store the settings JSON data in.

#### Constraint key
Specify the index column used for the constraint - this is used to differentiate between different users, objects or models (normally id).

#### Default constraint value
Specify the default constraint value - by default this will be the current user's ID, and will be superseded by specifying a `$constraint_value` on any function call.

#### Custom constraint
Specify a where clause for each query - set this if you **do not** want to access different rows (for example if your app is single-user only).


## Usage
Use the Setting facade (`Setting::`) or the helper function (`setting()->`) to access the methods in this package. The `$constraint_value` parameter is optional on all functions; if this is not passed, the `default_constraint_value` from the config file will be used.

#### Set
```php
Setting::set('key', 'value', $constraint_value);
setting()->set('key', 'value', $constraint_value);
```
Use `set` to change the value of a setting. If the setting does not exist, it will be created automatically. You can set multiple keys at once by passing an associative (key=>value) array to the first parameter.

#### Get
```php
Setting::get('key', 'default', $constraint_value);
setting()->get('key', 'default', $constraint_value);
setting('key', 'default', $constraint_value);
```
Use `get` to retrieve the value of a setting. The second parameter is optional and can be used to specify a default value if the setting does not exist (the default default value is `null`).

#### Forget
```php
Setting::forget('key', $constraint_value);
setting()->forget('key', $constraint_value);
```
Unset or delete a setting by calling `forget`.

#### Has
```php
Setting::has('key', $constraint_value);
setting()->has('key', $constraint_value);
```
Check for the existence of a setting, returned as a boolean.

#### All
```php
Setting::all($constraint_value);
setting()->all($constraint_value);
```
Retrieve all settings as an associative array (key=>value).

#### Save
```php
Setting::save($constraint_value);
setting()->save($constraint_value);
```
Save all changes back to the database. This will need to be called after making changes; it is not automatic.

#### Load
```php
Setting::load($constraint_value);
setting()->load($constraint_value);
```
Reload settings from the database. This is called automatically if settings have not been loaded before being accessed or mutated.


## Example
These examples are using the default configuration.

#### Using the default constraint value
The following sets and returns the currently logged in user's setting "example".
```php
// Set 'example' setting to 'hello world'
Setting::set('example', 'hello world');

// Save to database
Setting::save();

// Get the same setting
return Setting::get('example');
```

#### Specify a constraint value
The following sets and returns the setting "example" for the user with id of 23.
```php
// Set 'example' setting to 'hello world'
Setting::set('example', 'hello world', 23);

// Save to database
Setting::save(23);

// Get the same setting
return Setting::get('example', null, 23);
```


## Finally

#### Contributing
Feel free to create a fork and submit a pull request if you would like to contribute.

#### Bug reports
Raise an issue on GitHub if you notice something broken.

#### Credits
Based loosely on https://github.com/anlutro/laravel-settings.
