# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).


## [2.1.2] - 2016-11-08 14:31 GMT
##### Changed
- Store settings as `text` rather than `json` in the default migration (merges [#17], [#18], [#19] and fixes [#16]).

## [2.1.1] - 2016-08-01 11:06 GMT
##### Changed
- Store settings as `json` rather than `string` in the default migration (merges [#14]).

## [2.1.0] - 2015-12-29 16:37 GMT
##### Changed
- Support for Laravel 5.2 (use [version 2.0.x](https://github.com/Grimthorr/laravel-user-settings/tree/laravel5) for Laravel <5.2) (fixes [#9] and merges [#10]).

## [2.0.3] - 2015-03-24 08:44 GMT
##### Fixed
- Fix `forget` function not working (fixes [#5]).

## [2.0.2] - 2015-03-06 10:27 GMT
##### Changed
- Make use of Laravel's service container to correctly bind the `Setting` class as a singleton.

## [2.0.1] - 2015-03-05 16:02 GMT
##### Fixed
- Fix directory structure as per changes for Laravel 5 packages (fixes [#4]).

## [2.0.0] - 2015-03-02 11:35 GMT
##### Added
- Support for Laravel 5 (use [version 1.x](https://github.com/Grimthorr/laravel-user-settings/tree/laravel4) for Laravel 4).
- Helper function (`setting()`) for easy access to the Setting facade within a namespace.

##### Changed
- Master branch no longer supports Laravel 4.
- Config file provider adjusted for Laravel 5 support.

## [1.1.0] - 2015-02-23 13:49 GMT
##### Added
- Ability to specify a constraint on a per-call basis (see [#2]).

##### Changed
- Config file options have been changed to reflect the new constraint feature. **Note**: This change is backwards compatible; the old config file will work with this version, but the new feature will be disabled if 'constraint' is set. See readme for more details.

## [1.0.2] - 2015-01-21 16:34 GMT
##### Changed
- Check for authenticated user before getting the user ID in the default configuration file.

## [1.0.1] - 2015-01-21 11:58 GMT
##### Fixed
- Function forget() not saving changes (fixes [#1]).

## [1.0.0] - 2015-01-21 11:03 GMT
- Initial release.



[#1]: https://github.com/Grimthorr/laravel-user-settings/issues/1
[#2]: https://github.com/Grimthorr/laravel-user-settings/pull/2
[#4]: https://github.com/Grimthorr/laravel-user-settings/issues/4
[#5]: https://github.com/Grimthorr/laravel-user-settings/issues/5
[#9]: https://github.com/Grimthorr/laravel-user-settings/issues/9
[#10]: https://github.com/Grimthorr/laravel-user-settings/pull/10
[#14]: https://github.com/Grimthorr/laravel-user-settings/pull/14
[#16]: https://github.com/Grimthorr/laravel-user-settings/pull/14
[#17]: https://github.com/Grimthorr/laravel-user-settings/pull/14
[#18]: https://github.com/Grimthorr/laravel-user-settings/pull/14
[#19]: https://github.com/Grimthorr/laravel-user-settings/pull/14

[2.1.2]: https://github.com/Grimthorr/laravel-user-settings/compare/2.1.1...2.1.2
[2.1.1]: https://github.com/Grimthorr/laravel-user-settings/compare/2.1.0...2.1.1
[2.1.0]: https://github.com/Grimthorr/laravel-user-settings/compare/2.0.3...2.1.0
[2.0.3]: https://github.com/Grimthorr/laravel-user-settings/compare/2.0.2...2.0.3
[2.0.2]: https://github.com/Grimthorr/laravel-user-settings/compare/2.0.1...2.0.2
[2.0.1]: https://github.com/Grimthorr/laravel-user-settings/compare/2.0.0...2.0.1
[2.0.0]: https://github.com/Grimthorr/laravel-user-settings/compare/1.1.0...2.0.0
[1.1.0]: https://github.com/Grimthorr/laravel-user-settings/compare/1.0.2...1.1.0
[1.0.2]: https://github.com/Grimthorr/laravel-user-settings/compare/1.0.1...1.0.2
[1.0.1]: https://github.com/Grimthorr/laravel-user-settings/compare/1.0.0...1.0.1
[1.0.0]: https://github.com/Grimthorr/laravel-user-settings/tree/1.0.0
