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
composer require object-calisthenics/phpcs-calisthenics-rules "squizlabs/php_codesniffer:3.0.0RC4" --dev
```

Then, enable it as part of your CodeSniffer ruleset (ie. `ruleset.xml` in root project directory):

```xml
<!-- ruleset.xml -->
<?xml version="1.0" encoding="UTF-8"?>
<ruleset name="Project">
    <rule ref="vendor/object-calisthenics/phpcs-calisthenics-rules/src/ObjectCalisthenics/ruleset.xml"/>
</ruleset>
```


## Implemented Rules

### 1. Only One Level of Indentation per Method

[Read explanation with code examples](http://williamdurand.fr/2013/06/03/object-calisthenics/#1-only-one-level-of-indentation-per-method).

#### Sniff

- [`ObjectCalisthenics\Sniffs\Metrics\MaxNestingLevelSniff`](/src/ObjectCalisthenics/Sniffs/Metrics/MaxNestingLevelSniff.php)

This sniff is **configurable**:

```xml
<!-- ruleset.xml -->
<rule ref="ObjectCalisthenics.Metrics.MaxNestingLevel">
    <properties>
        <property name="maxNestingLevel" value="2"/>
    </properties>
</rule>
```


### 2. Do Not Use "else" Keyword

[Read explanation with code examples](http://williamdurand.fr/2013/06/03/object-calisthenics/#2-dont-use-the-else-keyword)

#### Sniff

- [`ObjectCalisthenics\Sniffs\ControlStructures\NoElseSniff`](/src/ObjectCalisthenics/Sniffs/ControlStructures/NoElseSniff.php)


### 5. Use Only One Object Operator (`->`) per Line

[Read explanation with code examples](http://williamdurand.fr/2013/06/03/object-calisthenics/#5-one-dot-per-line)

#### Sniff

- [`ObjectCalisthenics\Sniffs\CodeAnalysis\OneObjectOperatorPerLineSniff`](/src/ObjectCalisthenics\Sniffs\CodeAnalysis\OneObjectOperatorPerLineSniff.php)

This sniff is **configurable**:

```xml
<!-- ruleset.xml -->
<rule ref="ObjectCalisthenics.CodeAnalysis.OneObjectOperatorPerLine">
    <properties>
        <property name="variablesHoldingAFluentInterface" type="array" value="$queryBuilder"/>
        <property name="methodsStartingAFluentInterface" type="array" value="createQueryBuilder"/>
        <property name="methodsEndingAFluentInterface" type="array" value="execute,getQuery"/>
    </properties>
</rule>
```

### 6. Do not Abbreviate

[Read explanation](http://williamdurand.fr/2013/06/03/object-calisthenics/#6-dont-abbreviate)

#### Sniffs

- [`ObjectCalisthenics\Sniffs\NamingConventions\ClassNameLengthSniff`](/src/ObjectCalisthenics\Sniffs\NamingConventions\ClassNameLengthSniff.php)
- [`ObjectCalisthenics\Sniffs\NamingConventions\ConstantNameLengthSniff`](/src/ObjectCalisthenics\Sniffs\NamingConventions\ConstantNameLengthSniff.php)
- [`ObjectCalisthenics\Sniffs\NamingConventions\FunctionNameLengthSniff`](/src/ObjectCalisthenics\Sniffs\NamingConventions\FunctionNameLengthSniff.php)
- [`ObjectCalisthenics\Sniffs\NamingConventions\VariableNameLengthSniff`](/src/ObjectCalisthenics\Sniffs\NamingConventions\VariableNameLengthSniff.php)

These sniffs are **configurable**:

```xml
<!-- ruleset.xml -->
<rule ref="ObjectCalisthenics.NamingConventions.ClassNameLength">
    <properties>
        <property name="minLength" value="3"/>
    </properties>
</rule>
<rule ref="ObjectCalisthenics.NamingConventions.ConstantNameLength">
    <properties>
        <property name="minLength" value="3"/>
    </properties>
</rule>
<rule ref="ObjectCalisthenics.NamingConventions.FunctionNameLength">
    <properties>
        <property name="minLength" value="3"/>
    </properties>
</rule>
<rule ref="ObjectCalisthenics.NamingConventions.VariableNameLength">
    <properties>
        <property name="minLength" value="3"/>
        <property name="propertiesToBeSkipped" type="array"
                  value="id"
        />
    </properties>
</rule>
```


### 7. Keep Your Classes Small

[Read explanation](http://williamdurand.fr/2013/06/03/object-calisthenics/#7-keep-all-entities-small)

#### Sniffs

- [`ObjectCalisthenics\Sniffs\Files\ClassElementLengthSniff`](/src/ObjectCalisthenics\Sniffs\Files\ClassElementLengthSniff.php)
- [`ObjectCalisthenics\Sniffs\Metrics\MethodPerClassLimitSniff`](/src/ObjectCalisthenics/Sniffs/Metrics/MethodPerClassLimitSniff.php)
- [`ObjectCalisthenics\Sniffs\Metrics\PropertyPerClassLimitSniff`](/src/ObjectCalisthenics/Sniffs/Metrics/PropertyPerClassLimitSniff.php)
- [`ObjectCalisthenics\Sniffs\Files\FunctionLengthSniff`](/src/ObjectCalisthenics/Sniffs/Files/FunctionLengthSniff.php)

These sniffs are **configurable**:

```xml
<!-- ruleset.xml -->
<rule ref="ObjectCalisthenics.Files.ClassElementLength">
    <properties>
        <property name="maxLength" value="200"/>
    </properties>
</rule>
<rule ref="ObjectCalisthenics.Metrics.MethodPerClassLimit">
    <properties>
        <property name="maxCount" value="10"/>
    </properties>
</rule>
<rule ref="ObjectCalisthenics.Metrics.PropertyPerClassLimit">
    <properties>
        <property name="maxCount" value="10"/>
    </properties>
</rule>
<rule ref="ObjectCalisthenics.Files.FunctionLength">
    <properties>
        <property name="maxLength" value="20"/>
    </properties>
</rule>
```


### 8. Do Not Use Classes With More Than Two Instance Variables

[Read explanation with code examples](http://williamdurand.fr/2013/06/03/object-calisthenics/#8-no-classes-with-more-than-two-instance-variables)

#### Sniff

- [`ObjectCalisthenics\Sniffs\CodeAnalysis\InstancePropertyPerClassLimitSniff`](/src/ObjectCalisthenics\Sniffs\CodeAnalysis\InstancePropertyPerClassLimitSniff.php)

This sniff is **configurable**:

```xml
<!-- ruleset.xml -->
<rule ref="ObjectCalisthenics.CodeAnalysis.InstancePropertyPerClassLimit">
    <properties>
        <property name="maxCount" value="2"/>
    </properties>
</rule>
```


### 9. Do not Use Getters and Setters

[Read explanation with code examples](http://williamdurand.fr/2013/06/03/object-calisthenics/#9-no-getterssettersproperties)

- Classes should not contain public properties.
- Method should [represent behavior](http://whitewashing.de/2012/08/22/building_an_object_model__no_setters_allowed.html), not set values.

#### Sniffs

- [`ObjectCalisthenics\Sniffs\Classes\ForbiddenPublicPropertySniff`](/src/ObjectCalisthenics\Sniffs\Classes\ForbiddenPublicPropertySniff.php)
- [`ObjectCalisthenics\Sniffs\NamingConventions\NoSetterSniff`](/src/ObjectCalisthenics\Sniffs\NamingConventions\NoSetterSniff.php)

---

## Not Implemented Rules

### 3. Wrap Primitive Types and Strings

[Read explanation](http://williamdurand.fr/2013/06/03/object-calisthenics/#3- wrap-all-primitives-and-strings)

Since PHP 7, you can use `define(strict_types=1)` and scalar type hints:

```php
<?php define(strict_types=1);

final class Resolver
{
    public function resolveFromRoute(string $route): string
    {
        // ...
    }
}
```

For other cases, e.g. email, you can **deal with that in your [Domain via Value Objects](http://williamdurand.fr/2013/06/03/object-calisthenics/#wrap-all-primitives-and-strings)**.


### 4. Use First Class Collections

[Read explanation](http://williamdurand.fr/2013/06/03/object-calisthenics/#4-first-class-collections)

This rule makes sense, yet is too strict to be useful in practise. Even our code didn't pass it at all.


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
