# Object Calisthenics rules for [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)

[![Build Status](https://img.shields.io/travis/object-calisthenics/phpcs-calisthenics-rules.svg?style=flat-square)](https://travis-ci.org/object-calisthenics/phpcs-calisthenics-rules)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/object-calisthenics/phpcs-calisthenics-rules.svg?style=flat-square)](https://scrutinizer-ci.com/g/object-calisthenics/phpcs-calisthenics-rules)
[![Downloads](https://img.shields.io/packagist/dt/object-calisthenics/phpcs-calisthenics-rules.svg?style=flat-square)](https://packagist.org/packages/object-calisthenics/phpcs-calisthenics-rules)

Object Calisthenics are **set of rules in object-oriented code, that focuses of maintainability, readability, testability and comprehensibility**. We're **pragmatic first** - they are easy to use all together or one by one.


### Why Should You Use This in Your Project?

[Read post by *William Durand*](http://williamdurand.fr/2013/06/03/object-calisthenics/) or [check presentation by *Guilherme Blanco*](https://www.slideshare.net/guilhermeblanco/object-calisthenics-applied-to-php).


## Install

```sh
composer require object-calisthenics/phpcs-calisthenics-rules \
"squizlabs/php_codesniffer:3.0.0RC4" --dev
```


## Usage

### Via CLI

```bash
vendor/bin/phpcs src tests -sp \
--standard=vendor/object-calisthenics/phpcs-calisthenics-rules/src/ObjectCalisthenics/ruleset.xml
```

### The Best to Start With: Single Sniff via CLI

```bash
vendor/bin/phpcs src tests -sp \
--standard=vendor/object-calisthenics/phpcs-calisthenics-rules/src/ObjectCalisthenics/ruleset.xml \
--sniffs=ObjectCalisthenics.Classes.ForbiddenPublicProperty
```


## Implemented Rule Sniffs

### 1. [Only `X` Level of Indentation per Method](http://williamdurand.fr/2013/06/03/object-calisthenics/#1-only-one-level-of-indentation-per-method)

#### Example

❌

#### Apply in CLI?

```
--sniffs=ObjectCalisthenics.Metrics.MaxNestingLevel
```

**The class?** [`ObjectCalisthenics\Sniffs\Metrics\MaxNestingLevelSniff`](/src/ObjectCalisthenics/Sniffs/Metrics/MaxNestingLevelSniff.php)


#### ⚙ Configurable

- [in CodeSniffer XML](/src/ObjectCalisthenics/ruleset.xml#L3-L8)
- [in EasyCodingStandard NEON](/easy-coding-standard.neon#L4-L6)


### 2. [Do Not Use "else" Keyword](http://williamdurand.fr/2013/06/03/object-calisthenics/#2-dont-use-the-else-keyword)

#### Example

❌

```php
if ($isEnabled) {
    return true;
} else {
    return false;
}
```

✅

```php
if ($isEnabled) {
    return true;
}

return false;
```

#### Apply in CLI?

```
--sniffs=ObjectCalisthenics.ControlStructures.NoElseSniff
```

**The class?**

- [`ObjectCalisthenics\Sniffs\ControlStructures\NoElseSniff`](/src/ObjectCalisthenics/Sniffs/ControlStructures/NoElseSniff.php)


### 5. [Use Only One Object Operator (`->`) per Line](http://williamdurand.fr/2013/06/03/object-calisthenics/#5-one-dot-per-line)

#### Example

❌

@todo

✅

@todo

#### Apply in CLI?

```
--sniffs=ObjectCalisthenics.CodeAnalysis.OneObjectOperatorPerLine
```

**The class?** [`ObjectCalisthenics\Sniffs\CodeAnalysis\OneObjectOperatorPerLineSniff`](/src/ObjectCalisthenics\Sniffs\CodeAnalysis\OneObjectOperatorPerLineSniff.php)

#### ⚙ Configurable

- [in CodeSniffer XML](/src/ObjectCalisthenics/ruleset.xml#L13-L20)
- [in EasyCodingStandard NEON](/easy-coding-standard.neon#LX-LX)


### 6. [Do not Abbreviate](http://williamdurand.fr/2013/06/03/object-calisthenics/#6-dont-abbreviate)

This is concerned to class, trait, interface, constant, function and variable names.

#### Example

❌

@todo

✅

@todo


#### Apply in CLI?

```
--sniffs=ObjectCalisthenics.NamingConventions.ElementNameMinimalLength
```

**The class?**: [`ObjectCalisthenics\Sniffs\NamingConventions\ElementNameMinimalLengthSniff`](/src/ObjectCalisthenics\Sniffs\NamingConventions\ElementNameMinimalLengthSniff.php)

#### ⚙ Configurable

- [in CodeSniffer XML](/src/ObjectCalisthenics/ruleset.xml#L22-L28)
- [in EasyCodingStandard NEON](/easy-coding-standard.neon#LX-LX)


### 7. [Keep Your Classes Small](http://williamdurand.fr/2013/06/03/object-calisthenics/#7-keep-all-entities-small)

#### Example

❌

@todo

✅

@todo


#### Apply in CLI?

```
--sniffs=ObjectCalisthenics.Files.ClassTraitAndInterfaceLength,ObjectCalisthenics.Files.FunctionLengthSniff,ObjectCalisthenics.Metrics.MethodPerClassLimit,ObjectCalisthenics.Metrics.PropertyPerClassLimitSniff
```

**Classes?** [`ObjectCalisthenics\Sniffs\Files\ClassTraitAndInterfaceLengthSniff`](/src/ObjectCalisthenics\Sniffs\Files\ClassTraitAndInterfaceLengthSniff.php),[`ObjectCalisthenics\Sniffs\Metrics\MethodPerClassLimitSniff`](/src/ObjectCalisthenics/Sniffs/Metrics/MethodPerClassLimitSniff.php), [`ObjectCalisthenics\Sniffs\Metrics\PropertyPerClassLimitSniff`](/src/ObjectCalisthenics/Sniffs/Metrics/PropertyPerClassLimitSniff.php), [`ObjectCalisthenics\Sniffs\Files\FunctionLengthSniff`](/src/ObjectCalisthenics/Sniffs/Files/FunctionLengthSniff.php)

#### ⚙ Configurable

- [in CodeSniffer XML](/src/ObjectCalisthenics/ruleset.xml#L30-L50)
- [in EasyCodingStandard NEON](/easy-coding-standard.neon#LX-LX)


### 9. [Do not Use Getters and Setters](http://williamdurand.fr/2013/06/03/object-calisthenics/#9-no-getterssettersproperties)

This rules is partially related to [Domain Driven Design](https://github.com/dddinphp).

- Classes should not contain public properties.
- Method should [represent behavior](http://whitewashing.de/2012/08/22/building_an_object_model__no_setters_allowed.html), not set values.


#### Example

❌

@todo

✅

@todo


#### Apply in CLI?

```
--sniffs=ObjectCalisthenics.Classes.ForbiddenPublicProperty,ObjectCalisthenics.NamingConventions.NoSetter
```

**Classes?** [`ObjectCalisthenics\Sniffs\Classes\ForbiddenPublicPropertySniff`](/src/ObjectCalisthenics\Sniffs\Classes\ForbiddenPublicPropertySniff.php),[`ObjectCalisthenics\Sniffs\NamingConventions\NoSetterSniff`](/src/ObjectCalisthenics\Sniffs\NamingConventions\NoSetterSniff.php)

---

### Not Implemented Rules - Too Strict, Vague or Annoying

While using in practise, we found these rule to be too strict, vague or even annoying, rather then helping to write cleaner and more pragmatic code. They're also closely related with [Domain Driven Design](https://github.com/dddinphp).

**3. [Wrap Primitive Types and Strings](http://williamdurand.fr/2013/06/03/object-calisthenics/#3-wrap-all-primitives-and-strings)** - Since PHP 7, you can use `define(strict_types=1)` and scalar type hints. For other cases, e.g. email, you can deal with that in your [Domain via Value Objects](http://williamdurand.fr/2013/06/03/object-calisthenics/#3-wrap-all-primitives-and-strings).

**4. [Use First Class Collections](http://williamdurand.fr/2013/06/03/object-calisthenics/#4-first-class-collections)** - This rule makes sense, yet is too strict to be useful in practise. Even our code didn't pass it at all.

**8. [Do Not Use Classes With More Than Two Instance Variables](http://williamdurand.fr/2013/06/03/object-calisthenics/#8-no-classes-with-more-than-two-instance-variables)** -
This depends on individual domain of each project. It doesn't make sense to make a rule for that.

---

## 3 Rules for Contributing

- **1 feature per PR**
- every new feature **must be covered by tests**
- **all tests** and **style checks must pass**

    ```bash
    composer complete-check
    ```

We will be happy to merge your feature then.
