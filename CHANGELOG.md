# Changelog

## Next release


## 2.1.0 - 2020-04-08 - minor release

### Added
- Implementation of the `Castable` interface of Laravel 7.5 


## 2.0.0 - 2020-03-29 - major release

### Added
- Laravel 7.x support
- Laravel 7 custom casts
- `Configurable`-trait for enums

### Changed
- Dropped Support for version of Laravel lower than 7.0
- Dropped Support for versions of PHP lower than 7.3
- Removed `HasEnums`-trait in favor of custom casts
- Removed possibility to set weight path by static property to prevent notices when accessing undefined properties


## 1.3.0 - 2019-08-31 - minor release

### Added
- weighted enums

### Changed
- various fixes regarding the readme


## 1.2.0 - 2019-07-24 - minor release

### Changed
- `__toString` has proper return type hint
- Dependencies now properly allow laravel 5.7+

### Added
- `is(EnumValue)` method to `Enumeration` (#2)
- `is<EnumValue>()` methods to `Enumeration` via `__call` (#2)


## 1.1.0 - 2019-04-04 - minor release

### Fixed
- the `lint:phpmd`-script no longer searches for a non existing directory
- localization for the `EnumerationValue`-message

### Changed
- `__toString` now returns the value and not the key of the member

### Added
- `defaultMember` method to `Enumeration`
- `HasEnums` trait for laravel models


## 1.0.1 - 2019-03-07 - patch release

### Fixed
- return type hint in doc block for `makeRuleWithWhitelist` in `Sourceboat\Enumeration\Enumeration`
- typo in readme


## 1.0.0 - 2019-03-06 - inital release

### Added
- abstract enumeration class
- rule for validation
- command to generate enum: `artisan make:enum`
