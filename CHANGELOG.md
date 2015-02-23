# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

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

[1.1.0]: https://github.com/Grimthorr/laravel-user-settings/compare/1.0.2...1.1.0
[1.0.2]: https://github.com/Grimthorr/laravel-user-settings/compare/1.0.1...1.0.2
[1.0.1]: https://github.com/Grimthorr/laravel-user-settings/compare/1.0.0...1.0.1
[1.0.0]: https://github.com/Grimthorr/laravel-user-settings/tree/1.0.0
