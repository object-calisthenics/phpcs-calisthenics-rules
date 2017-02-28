# Object Calisthenics rules for [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)

[![Build Status](https://img.shields.io/travis/object-calisthenics/phpcs-calisthenics-rules.svg?style=flat-square)](https://travis-ci.org/object-calisthenics/phpcs-calisthenics-rules)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/object-calisthenics/phpcs-calisthenics-rules.svg?style=flat-square)](https://scrutinizer-ci.com/g/object-calisthenics/phpcs-calisthenics-rules)
[![Downloads](https://img.shields.io/packagist/dt/object-calisthenics/phpcs-calisthenics-rules.svg?style=flat-square)](https://packagist.org/packages/object-calisthenics/phpcs-calisthenics-rules)
[![PHPStan](https://img.shields.io/badge/PHPStan-enabled-brightgreen.svg?style=flat-square)](https://github.com/phpstan/phpstan)

Object Calisthenics are **set of rules in object-oriented code, that focuses of maintainability, readability, testability and comprehensibility**.

### Where to read more about Object Calisthenics?


Are you interested in **motivation and reasons behind them**?

- [Read post by William Durand](http://williamdurand.fr/2013/06/03/object-calisthenics/) or
- [post by Diego Mariani](https://medium.com/web-engineering-vox/improving-code-quality-with-object-calisthenics-aa4ad67a61f1).

Do you **prefer slides**?

- [Here are 58 of them in presentation by Guilherme Blanco](https://www.slideshare.net/guilhermeblanco/object-calisthenics-applied-to-php), the founding father of this project.


## Install

Via composer:

```sh
composer require object-calisthenics/phpcs-calisthenics-rules --dev
```

Then, enable it as part of your CodeSniffer ruleset (ie. `phpcs.xml` in root project directory):

```xml
<?xml version="1.0" encoding="UTF-8"?>
<ruleset name="Project">
    <rule ref="vendor/object-calisthenics/phpcs-calisthenics-rules/src/ObjectCalisthenics/ruleset.xml"/>
</ruleset>
```


## Implemented Rules

### 1. Only One Level of Indentation per Method

- [`ObjectCalisthenics\Sniffs\Metrics\OneIndentationLevelSniff`](/blob/master/src/ObjectCalisthenics/Sniffs/Metrics/OneIndentationLevelSniff.php)


### 2. Do Not Use "else" Keyword

- [`ObjectCalisthenics\Sniffs\ControlStructures\NoElseSniff`](/blob/master/src/ObjectCalisthenics/Sniffs/ControlStructures/NoElseSniff.php)


### 4. Use First Class Collections

- [`ObjectCalisthenics\Sniffs\CodeAnalysis\ArrayPropertyPerClassLimitSniff`](/blob/master/src/ObjectCalisthenics\Sniffs\CodeAnalysis\ArrayPropertyPerClassLimitSniff.php)


### 5. Use Only One Object Operator per Line

- [`ObjectCalisthenics\Sniffs\CodeAnalysis\OneObjectOperatorPerLineSniff`](/blob/master/src/ObjectCalisthenics\Sniffs\CodeAnalysis\OneObjectOperatorPerLineSniff.php)


### 6. Do not Abbreviate

- [`ObjectCalisthenics\Sniffs\NamingConventions\ClassLengthSniff`](/blob/master/src/ObjectCalisthenics\Sniffs\NamingConventions\ClassLengthSniff.php)
- [`ObjectCalisthenics\Sniffs\NamingConventions\ConstantLengthSniff`](/blob/master/src/ObjectCalisthenics\Sniffs\NamingConventions\ConstantLengthSniff.php)
- [`ObjectCalisthenics\Sniffs\NamingConventions\FunctionLengthSniff`](/blob/master/src/ObjectCalisthenics\Sniffs\NamingConventions\FunctionLengthSniff.php)
- [`ObjectCalisthenics\Sniffs\NamingConventions\VariableLengthSniff`](/blob/master/src/ObjectCalisthenics\Sniffs\NamingConventions\VariableLengthSniff.php)


### 7. Keep Your Classes Small

- [`ObjectCalisthenics\Sniffs\Metrics\MethodPerClassLimitSniff`)[/blob/master/src/ObjectCalisthenics/Sniffs/Metrics/MethodPerClassLimitSniff.php]
- [`ObjectCalisthenics\Sniffs\Files\ClassElementLengthSniff`](/blob/master/src/ObjectCalisthenics\Sniffs\Files\ClassElementLengthSniff.php)
- [`ObjectCalisthenics\Sniffs\Files\FunctionLengthSniff`](/blob/master/src/ObjectCalisthenics\Sniffs\Files\FunctionLengthSniff.php)


### 8. Do Not Use Classes With More Than Two Instance Variables

- [`ObjectCalisthenics\Sniffs\CodeAnalysis\InstancePropertyPerClassLimitSniff`](/blob/master/src/ObjectCalisthenics\Sniffs\CodeAnalysis\InstancePropertyPerClassLimitSniff.php)


### 9. Do not Use Getters and Setters

- Classes should not contain public properties.
- Method should [represent behavior](http://whitewashing.de/2012/08/22/building_an_object_model__no_setters_allowed.html), not set values.

- [`ObjectCalisthenics\Sniffs\Classes\PropertyVisibilitySniff`](/blob/master/src/ObjectCalisthenics\Sniffs\Classes\PropertyVisibilitySniff.php)
- [`ObjectCalisthenics\Sniffs\NamingConventions\NoSetterSniff`](/blob/master/src/ObjectCalisthenics\Sniffs\NamingConventions\NoSetterSniff.php)

---

## Not Implemented Rules

### 3. Wrap Primitive Types and Strings

Since PHP 7, you can use `define(strict_types=1)` and scalar type hints:

```php
define(strict_types=1);

final class Resolver
{
    public function resolveFromRoute(string $route): string
    {
        // ...
    }
}
```

For other cases, e.g. email, you can **deal with that in your [Domain via Value Objects](http://williamdurand.fr/2013/06/03/object-calisthenics/#wrap-all-primitives-and-strings)**.


## 3 Rules for Contributing

- **1 feature per PR**
- every new feature **must be covered by tests**
- **all tests** and **style checks must pass**

```bash
# runs PHPStan, coding standard check and tests,
# see "scripts" section in composer.json for more
composer complete-check
```

We will be happy to merge your feature then.
