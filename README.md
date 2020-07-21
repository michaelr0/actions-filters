[![Latest Version on Packagist](https://img.shields.io/packagist/v/michaelr0/actions-filters.svg?style=flat-square)](https://packagist.org/packages/michaelr0/actions-filters)
[![Total Downloads](https://img.shields.io/packagist/dt/michaelr0/actions-filters.svg?style=flat-square)](https://packagist.org/packages/michaelr0/actions-filters) 
[![StyleCI](https://github.styleci.io/repos/280111623/shield?branch=master)](https://github.styleci.io/repos/280111623?branch=master) 
[![Build Status](https://img.shields.io/travis/michaelr0/actions-filters/master.svg?style=flat-square)](https://travis-ci.org/michaelr0/actions-filters)
[![Quality Score](https://img.shields.io/scrutinizer/g/michaelr0/actions-filters.svg?style=flat-square)](https://scrutinizer-ci.com/g/michaelr0/actions-filters)
[![Code Coverage](https://scrutinizer-ci.com/g/michaelr0/actions-filters/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/michaelr0/actions-filters/?branch=master)

Actions And Filters is an Action and Filter library inspired by WordPress Actions and Filters.


## Installation

You can install the package via composer:

```bash
composer require michaelr0/actions-filters
```

## [Documentation/Wiki](https://github.com/michaelr0/actions-filters/wiki)

## Usage

### With Laravel
``` php

// Filter Example

// Add a filter callback to a function by name
Filter::add('Test', 'ucfirst');

// Add a filter callback to a closure function
Filter::add('Test', function($value){
    return "{$value} {$value}";
});

// Will return Foobar Foobar
Filter::run('Test', 'foobar');

// /Filter Example

// Action Example

// Eample function for test
function action_test($value){
    DB::table('users')->where('name', $value)->delete();
}

// Add a action callback to a function by name
Action::add('DeleteUser', 'action_test');
// Or

// Add a action callback to a closure function
Action::add('DeleteUser', function($value){
    action_test($value);
    // Or this closure function could just do DB::table('users')->where('name', $value)->delete();
});

// Execute the action, which in this example will find/delete a user named foobar
Action::run('DeleteUser', 'foobar');

// /Action Example

```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email michael@rook.net.au instead of using the issue tracker.

## Credits

- [Michael Rook](https://github.com/michaelr0)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
