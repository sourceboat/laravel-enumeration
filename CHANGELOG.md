# Changelog

## NEXT RELEASE

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
