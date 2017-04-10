# Object Calisthenics rules for [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)

[![Build Status](https://img.shields.io/travis/object-calisthenics/phpcs-calisthenics-rules.svg?style=flat-square)](https://travis-ci.org/object-calisthenics/phpcs-calisthenics-rules)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/object-calisthenics/phpcs-calisthenics-rules.svg?style=flat-square)](https://scrutinizer-ci.com/g/object-calisthenics/phpcs-calisthenics-rules)
[![Downloads](https://img.shields.io/packagist/dt/object-calisthenics/phpcs-calisthenics-rules.svg?style=flat-square)](https://packagist.org/packages/object-calisthenics/phpcs-calisthenics-rules)

Object Calisthenics are **set of rules in object-oriented code, that focuses of maintainability, readability, testability and comprehensibility**. We're **pragmatic first** - they are easy to use all together or one by one.


### Why Should You Use This in Your Project?

[Read post by *William Durand*](http://williamdurand.fr/2013/06/03/object-calisthenics/) or [post by *Diego Mariani*](https://medium.com/web-engineering-vox/improving-code-quality-with-object-calisthenics-aa4ad67a61f1).

Do you prefer slides? [Check presentation by *Guilherme Blanco*](https://www.slideshare.net/guilhermeblanco/object-calisthenics-applied-to-php).


## Install

```sh
composer require object-calisthenics/phpcs-calisthenics-rules "squizlabs/php_codesniffer:3.0.0RC4" --dev
```

## Usage

### Via CLI

```bash
vendor/bin/phpcs src tests --standard=vendor/object-calisthenics/phpcs-calisthenics-rules/src/ObjectCalisthenics/ruleset.xml
```

### The Best to Start With: Single Sniff via CLI

```bash
vendor/bin/phpcs src tests --standard=vendor/object-calisthenics/phpcs-calisthenics-rules/src/ObjectCalisthenics/ruleset.xml --sniffs=ObjectCalisthenics.Classes.ForbiddenPublicProperty
```

## Implemented Rule Sniffs


### 1. [Only One Level of Indentation per Method](http://williamdurand.fr/2013/06/03/object-calisthenics/#1-only-one-level-of-indentation-per-method)

**Apply in CLI?** `--sniffs=ObjectCalisthenics.Metrics.MaxNestingLevel`

**The class?** [`ObjectCalisthenics\Sniffs\Metrics\MaxNestingLevelSniff`](/src/ObjectCalisthenics/Sniffs/Metrics/MaxNestingLevelSniff.php)

#### Configurable

In CodeSniffer XML:

```xml
<!-- ruleset.xml -->
<rule ref="ObjectCalisthenics.Metrics.MaxNestingLevel">
    <properties>
        <property name="maxNestingLevel" value="2"/>
    </properties>
</rule>
```


### 2. [Do Not Use "else" Keyword](http://williamdurand.fr/2013/06/03/object-calisthenics/#2-dont-use-the-else-keyword)

**Apply in CLI?** `--sniffs=ObjectCalisthenics.ControlStructures.NoElseSniff`

**The class?** [`ObjectCalisthenics\Sniffs\ControlStructures\NoElseSniff`](/src/ObjectCalisthenics/Sniffs/ControlStructures/NoElseSniff.php)


### 5. [Use Only One Object Operator (`->`) per Line](http://williamdurand.fr/2013/06/03/object-calisthenics/#5-one-dot-per-line)

**Apply in CLI?** `--sniffs=ObjectCalisthenics.CodeAnalysis.OneObjectOperatorPerLine`

**The class?** [`ObjectCalisthenics\Sniffs\CodeAnalysis\OneObjectOperatorPerLineSniff`](/src/ObjectCalisthenics\Sniffs\CodeAnalysis\OneObjectOperatorPerLineSniff.php)

#### Configurable

In CodeSniffer XML:

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


### 6. [Do not Abbreviate](http://williamdurand.fr/2013/06/03/object-calisthenics/#6-dont-abbreviate)

This is concerned to class, trait, interface, constant, function and variable names.

**Apply in CLI?** `--sniffs=ObjectCalisthenics.NamingConventions.ElementNameMinimalLength`

**The class?**: [`ObjectCalisthenics\Sniffs\NamingConventions\ElementNameMinimalLengthSniff`](/src/ObjectCalisthenics\Sniffs\NamingConventions\ElementNameMinimalLengthSniff.php)

#### Configurable

```xml
<!-- ruleset.xml -->
<rule ref="ObjectCalisthenics.NamingConventions.ElementNameMinimalLength">
    <properties>
        <property name="minLength" value="3"/>
        <property name="allowedShortNames" type="array"
                  value="i,id,to"
        />
    </properties>
</rule>
```


### 7. [Keep Your Classes Small](http://williamdurand.fr/2013/06/03/object-calisthenics/#7-keep-all-entities-small)

**Apply in CLI?** `--sniffs=ObjectCalisthenics.Files.ClassElementLength,ObjectCalisthenics.Files.FunctionLengthSniff,ObjectCalisthenics.Metrics.MethodPerClassLimit,ObjectCalisthenics.Metrics.PropertyPerClassLimitSniff`

**Classes?** [`ObjectCalisthenics\Sniffs\Files\ClassTraitAndInterfaceLengthSniff`](/src/ObjectCalisthenics\Sniffs\Files\ClassTraitAndInterfaceLengthSniff.php),[`ObjectCalisthenics\Sniffs\Metrics\MethodPerClassLimitSniff`](/src/ObjectCalisthenics/Sniffs/Metrics/MethodPerClassLimitSniff.php), [`ObjectCalisthenics\Sniffs\Metrics\PropertyPerClassLimitSniff`](/src/ObjectCalisthenics/Sniffs/Metrics/PropertyPerClassLimitSniff.php), [`ObjectCalisthenics\Sniffs\Files\FunctionLengthSniff`](/src/ObjectCalisthenics/Sniffs/Files/FunctionLengthSniff.php)

#### Configurable

In CodeSniffer XML:

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

### 9. [Do not Use Getters and Setters](http://williamdurand.fr/2013/06/03/object-calisthenics/#9-no-getterssettersproperties)

**Apply in CLI?** `--sniffs=ObjectCalisthenics.Classes.ForbiddenPublicProperty,ObjectCalisthenics.NamingConventions.NoSetter`

**Classes?** [`ObjectCalisthenics\Sniffs\Classes\ForbiddenPublicPropertySniff`](/src/ObjectCalisthenics\Sniffs\Classes\ForbiddenPublicPropertySniff.php),[`ObjectCalisthenics\Sniffs\NamingConventions\NoSetterSniff`](/src/ObjectCalisthenics\Sniffs\NamingConventions\NoSetterSniff.php)

This rules is partially related to [Domain Driven Design](https://github.com/dddinphp).

- Classes should not contain public properties.
- Method should [represent behavior](http://whitewashing.de/2012/08/22/building_an_object_model__no_setters_allowed.html), not set values.

---

### Not Implemented Rules - Too Strict, Vague or Annoying

While using in practise, we found these rule to be too much strict, vague or even annoying, rather then helping to write cleaner and more pragmatic code.

They're also closely related with [Domain Driven Design](https://github.com/dddinphp).


#### 3. [Wrap Primitive Types and Strings](http://williamdurand.fr/2013/06/03/object-calisthenics/#3-wrap-all-primitives-and-strings)

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

For other cases, e.g. email, you can **deal with that in your [Domain via Value Objects](http://williamdurand.fr/2013/06/03/object-calisthenics/#3-wrap-all-primitives-and-strings)**.


#### 4. [Use First Class Collections](http://williamdurand.fr/2013/06/03/object-calisthenics/#4-first-class-collections)

This rule makes sense, yet is too strict to be useful in practise. Even our code didn't pass it at all.


#### 8. [Do Not Use Classes With More Than Two Instance Variables](http://williamdurand.fr/2013/06/03/object-calisthenics/#8-no-classes-with-more-than-two-instance-variables)

This depends on your specific domain and approach. It doesn't make sense to make a rule for that, because it's unique per project.



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
