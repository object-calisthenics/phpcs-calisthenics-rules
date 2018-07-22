# Object Calisthenics rules for [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)

[![Build Status](https://img.shields.io/travis/object-calisthenics/phpcs-calisthenics-rules/master.svg?style=flat-square)](https://travis-ci.org/object-calisthenics/phpcs-calisthenics-rules)
[![Coverage Status](https://img.shields.io/coveralls/object-calisthenics/phpcs-calisthenics-rules/master.svg?style=flat-square)](https://coveralls.io/github/object-calisthenics/phpcs-calisthenics-rules)
[![Downloads](https://img.shields.io/packagist/dt/object-calisthenics/phpcs-calisthenics-rules.svg?style=flat-square)](https://packagist.org/packages/object-calisthenics/phpcs-calisthenics-rules)

Object Calisthenics are **set of rules in object-oriented code, that focuses of maintainability, readability, testability and comprehensibility**. We're **pragmatic first** - they are easy to use all together or one by one.


### Why Should You Use This in Your Project?

[Read post by *William Durand*](http://williamdurand.fr/2013/06/03/object-calisthenics/) or [check presentation by *Guilherme Blanco*](https://www.slideshare.net/guilhermeblanco/object-calisthenics-applied-to-php).


## Install

```sh
composer require object-calisthenics/phpcs-calisthenics-rules --dev
```

## Usage

### In PHP_CodeSniffer

```bash
vendor/bin/phpcs src tests -sp \
--standard=vendor/object-calisthenics/phpcs-calisthenics-rules/src/ObjectCalisthenics/ruleset.xml
```

or

```bash
vendor/bin/phpcs src tests -sp \
--standard=vendor/object-calisthenics/phpcs-calisthenics-rules/src/ObjectCalisthenics/ruleset.xml \
--sniffs=ObjectCalisthenics.Classes.ForbiddenPublicProperty
```

### In EasyCodingStandard

```bash
vendor/bin/ecs check src --config vendor/object-calisthenics/phpcs-calisthenics-rules/config/object-calisthenics.yml
```

or

```yml
# easy-coding-standard.yml
imports:
    - { resource: 'vendor/object-calisthenics/phpcs-calisthenics-rules/config/object-calisthenics.yml' }
```

---

## Implemented Rule Sniffs

### 1. [Only `X` Level of Indentation per Method](http://williamdurand.fr/2013/06/03/object-calisthenics/#1-only-one-level-of-indentation-per-method)

:x:

```php
foreach ($sniffGroups as $sniffGroup) {
    foreach ($sniffGroup as $sniffKey => $sniffClass) {
        if (! $sniffClass instanceof Sniff) {
            throw new InvalidClassTypeException;
        }
    }
}
```

:+1:

```php
foreach ($sniffGroups as $sniffGroup) {
    $this->ensureIsAllInstanceOf($sniffGroup, Sniff::class);
}

// ...
private function ensureIsAllInstanceOf(array $objects, string $type)
{
    // ...
}
```

#### Use Just This One?

```bash
--sniffs=ObjectCalisthenics.Metrics.MaxNestingLevel
```

```yml
# easy-coding-standard.yml
services:
    ObjectCalisthenics\Sniffs\Metrics\MaxNestingLevelSniff: ~
```

#### :wrench: Configurable

- [in CodeSniffer XML](/src/ObjectCalisthenics/ruleset.xml#L3-L8)
- [in EasyCodingStandard YAML](/config/object-calisthenics.yml#L12-L14)

---

### 2. [Do Not Use "else" Keyword](http://williamdurand.fr/2013/06/03/object-calisthenics/#2-dont-use-the-else-keyword)

:x:

```php
if ($status === self::DONE) {
    $this->finish();
} else {
    $this->advance();
}
```

:+1:

```php
if ($status === self::DONE) {
    $this->finish();
    return;
}

$this->advance();
```

#### Use Just This One?

```
--sniffs=ObjectCalisthenics.ControlStructures.NoElseSniff
```

```yml
# easy-coding-standard.yml
services:
    ObjectCalisthenics\Sniffs\ControlStructures\NoElseSniff: ~
```

---

### 5. [Use Only One Object Operator (`->`) per Line](http://williamdurand.fr/2013/06/03/object-calisthenics/#5-one-dot-per-line)

:x:

```php
$this->container->getBuilder()->addDefinition(SniffRunner::class);
```

:+1:

```php
$containerBuilder = $this->getContainerBuilder();
$containerBuilder->addDefinition(SniffRunner::class);
```

#### Use Just This One?

```bash
--sniffs=ObjectCalisthenics.CodeAnalysis.OneObjectOperatorPerLine
```

```yml
# easy-coding-standard.yml
services:
    ObjectCalisthenics\Sniffs\CodeAnalysis\OneObjectOperatorPerLineSniff: ~
```

#### :wrench: Configurable

- [in CodeSniffer XML](/src/ObjectCalisthenics/ruleset.xml#L13-L20)
- [in EasyCodingStandard YAML](/config/object-calisthenics.yml#L19-L23)

---

### 6. [Do not Abbreviate](http://williamdurand.fr/2013/06/03/object-calisthenics/#6-dont-abbreviate)

This is related to class, trait, interface, constant, function and variable names.

:x:

```php
class EM
{
    // ...
}
```

:+1:

```php
class EntityMailer
{
    // ...
}
```

#### Use Just This One?

```bash
--sniffs=ObjectCalisthenics.NamingConventions.ElementNameMinimalLength
```

```yml
# easy-coding-standard.yml
services:
    ObjectCalisthenics\Sniffs\NamingConventions\ElementNameMinimalLengthSniff: ~
```

#### :wrench: Configurable

- [in CodeSniffer XML](/src/ObjectCalisthenics/ruleset.xml#L22-L28)
- [in EasyCodingStandard YAML](/config/object-calisthenics.yml#L25-L28)

---

### 7. [Keep Your Classes Small](http://williamdurand.fr/2013/06/03/object-calisthenics/#7-keep-all-entities-small)

:x:

```php
class SimpleStartupController
{
    // 300 lines of code
}
```

:+1:

```php
class SimpleStartupController
{
    // 50 lines of code
}
```

:x:

```php
class SomeClass
{
    public function simpleLogic()
    {
        // 30 lines of code
    }
}
```

:+1:

```php
class SomeClass
{
    public function simpleLogic()
    {
        // 10 lines of code
    }
}
```

:x:

```php
class SomeClass
{
    // 20 properties
}
```

:+1:

```php
class SomeClass
{
    // 5 properties
}
```

:x:

```php
class SomeClass
{
    // 20 methods
}
```

:+1:

```php
class SomeClass
{
    // 5 methods
}
```


#### Use Just These Ones?

```bash
--sniffs=ObjectCalisthenics.Files.ClassTraitAndInterfaceLength,ObjectCalisthenics.Files.FunctionLengthSniff,ObjectCalisthenics.Metrics.MethodPerClassLimit,ObjectCalisthenics.Metrics.PropertyPerClassLimitSniff
```

```yml
# easy-coding-standard.yml
services:
    ObjectCalisthenics\Sniffs\Files\ClassTraitAndInterfaceLengthSniff: ~
    ObjectCalisthenics\Sniffs\Files\FunctionLengthSniff: ~
    ObjectCalisthenics\Sniffs\Metrics\MethodPerClassLimitSniff: ~
    ObjectCalisthenics\Sniffs\Metrics\PropertyPerClassLimitSniff: ~
```

#### :wrench: Configurable

- [in CodeSniffer XML](/src/ObjectCalisthenics/ruleset.xml#L30-L50)
- [in EasyCodingStandard YAML](/config/object-calisthenics.yml#L30-L38)

---

### 9. [Do not Use Getters and Setters](http://williamdurand.fr/2013/06/03/object-calisthenics/#9-no-getterssettersproperties)

This rules is partially related to [Domain Driven Design](https://github.com/dddinphp).

- Classes should not contain public properties.
- Method should [represent behavior](http://whitewashing.de/2012/08/22/building_an_object_model__no_setters_allowed.html), not set values.

:x:

```php
class ImmutableBankAccount
{
    public $currency = 'USD';
```
```php
    private $amount;

    public function setAmount(int $amount)
    {
        $this->amount = $amount;
    }
}
```

:+1:

```php
class ImmutableBankAccount
{
    private $currency = 'USD';
```
```php
    private $amount;

    public function withdrawAmount(int $withdrawnAmount)
    {
        $this->amount -= $withdrawnAmount;
    }
}
```

#### Use Just These Ones?

```bash
--sniffs=ObjectCalisthenics.Classes.ForbiddenPublicProperty,ObjectCalisthenics.NamingConventions.NoSetter
```

```yml
# easy-coding-standard.yml
services:
    ObjectCalisthenics\Sniffs\Classes\ForbiddenPublicPropertySniff: ~
    ObjectCalisthenics\Sniffs\NamingConventions\NoSetterSniff: ~
```

#### :wrench: Configurable

```yml
# easy-coding-standard.yml
services:
    ObjectCalisthenics\Sniffs\NamingConventions\NoSetterSniff:
        allowedClasses: 
            - '*\DataObject'
```

---

### Not Implemented Rules - Too Strict, Vague or Annoying

While using in practice, we found these rule to be too strict, vague or even annoying, rather than helping to write cleaner and more pragmatic code. They're also closely related with [Domain Driven Design](https://github.com/dddinphp).

**3. [Wrap Primitive Types and Strings](http://williamdurand.fr/2013/06/03/object-calisthenics/#3-wrap-all-primitives-and-strings)** - Since PHP 7, you can use `define(strict_types=1)` and scalar type hints. For other cases, e.g. email, you can deal with that in your [Domain via Value Objects](http://williamdurand.fr/2013/06/03/object-calisthenics/#3-wrap-all-primitives-and-strings).

**4. [Use First Class Collections](http://williamdurand.fr/2013/06/03/object-calisthenics/#4-first-class-collections)** - This rule makes sense, yet is too strict to be useful in practice. Even our code didn't pass it at all.

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
