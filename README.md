# PHPCS-Calisthenics-Rules

A [PHP Code Sniffer](http://pear.php.net/package/PHP_CodeSniffer/) standard to verify Object Calisthenics rules.


## Installation

If you prefer using [Composer](http://getcomposer.org/) you can easily install Object Calisthenics rules system-wide with the following command:

    composer global require "object-calisthenics/phpcs-calisthenics-rules=*"

Make sure you have `~/.composer/vendor/bin/` in your PATH.

Or alternatively, include a dependency for `object-calisthenics/phpcs-calisthenics-rules` in your `composer.json` file. For example:

    {
        "require-dev": {
            "squizlabs/php_codesniffer": "dev-master",
            "object-calisthenics/phpcs-calisthenics-rules": "dev-master"
        }
    }

Finally, enable it as part of your project code sniffer ruleset (ie. phpcs.xml in root project directory):

    <?xml version="1.0" encoding="UTF-8"?>
    <ruleset name="Project">
        <description>Project Coding Standard</description>

        <rule ref="vendor/object-calisthenics/phpcs-calisthenics-rules/ObjectCalisthenics/ruleset.xml"/>
    </ruleset>


# Object Calisthenics

[The ThoughtWorks Anthology](http://pragprog.com/book/twa/thoughtworks-anthology), a technical book published by [The Pragmatic Programmers](http://pragprog.com), introduced a technique called [Object Calisthenics](http://www.xpteam.com/jeff/writings/objectcalisthenics.rtf), proposed by [Jeff Bay](http://www.xpteam.com/jeff), who used to be the Technology Principal at [ThoughtWorks](http://www.thoughtworks.com). 
The **adapted excerpts** present the author's motivation, as well as the proposed exercise and rules, ported to PHP language.


## Motivation

We've all seen poorly written code that's hard to understand, test and maintain.
Object-oriented programming promised to save us from our old procedural code, allowing us to write software incrementally, reusing as we go. 
But sometimes it seems like we're just chasing down the same old complex, coupled designs in Java that we had in C.

Good object-oriented design can be hard to learn. 
Transitioning from procedural development to object-oriented design requires a major shift in thinking that is more difficult than it seems. 
Many developers assume they're doing a good job with OO design, when in reality they're unconsciously stuck in procedural habits that are hard to break. 
It doesn't help that many examples and best practices encourage poor OO design in the name of performance or the simple weight of history.

The core concepts behind good design are well understood. 
[Alan Shalloway](http://www.netobjectives.com/bio-alan-shalloway) has suggested that seven code qualities matter: cohesion, loose coupling, zero duplication, encapsulation, testability, readability and focus. 
Yet it's hard to put those concepts into practice. 
It is one thing to understand that encapsulation means hiding data, implementation, type, design, or construction. 
It's another thing altogether to design code that implements encapsulation well.


## Proposed Exercise

Code a project using far stricter coding standards then you've ever used in your life. 
In this section you'll find rules that will help push you into writing code that is almost required to be object-oriented. 
This will allow you to make better decisions and give you more and better options when confronted with the problems of your day job.

By suspending disbelief and rigidly applying these rules on a project, you'll start to see a significantly different approach to designing software. 
Once you've written the core components, the exercise is done, and you can relax and go back to using these rules as guidelines.

This is a hard exercise, especially because many of these rules are not universally applicable. 
The fact is that sometimes classes are little more than 200 lines. 
But there's great value in thinking about what would have to happen to move those responsibilities into real, first-class objects of their own. 
It's developing this type of thinking that's the real value of the exercise. 
So, stretch the limits of what you imagine is possible, and see whether you start thinking about your code in a new way.


## Proposed Rules


### Rule #1: Only one level of indentation

- Status: **Implemented**

Ever stare at a big old method wondering where to start? A giant method lacks cohesiveness. 
One guideline is to limit method length to five lines, but that kind of transition can be daunting if your code is littered with 500-line monsters. 
Instead, try to ensure that each method does exactly one thing - one control structure or one block of statements per method. 
If you've got nested control structures in a method, you're working at multiple levels of abstraction, and that means you're doing more than one thing.

As you work with methods that do exactly one thing, expressed within classes doing exactly one thing, your code begins to change. 
As each unit in your application becomes smaller, your level of re-use will start to rise exponentially. 
It can be difficult to spot opportunities for reuse within a method that has five responsibilities and is implemented in 100 lines. 
A three-line method that manages the state of a single object in a given context is usable in many different contexts.

#### Benefits:

- Single Responsibility Principle ("S" in SOLID)
- Benefits reusability


### Rule #2: Do not use "else" keyword

- Status: **Implemented**

Every programmer understands the **if/else** construct. 
It's built into nearly every programming language, and simple conditional logic is easy for anyone to understand. 
Nearly every programmer has seen a nasty nested conditional that's impossible to follow, or a case statement that goes on for pages. 
Even worse, it is all too easy to simply add another branch to an existing conditional rather than factoring to a better solution. 
Conditionals are also a frequent source of duplication.

When a given method provides one behavior for the **if** branch, and another behavior for the **else** branch, then it means that this particular method is not cohesive. 
It has got more than one responsibility, dealing with different behaviors.

Object-oriented languages give you a powerful tool - [Polymorphism](http://en.wikipedia.org/wiki/Type_polymorphism) - for handling complex conditional cases. 
Simple cases can be replaced with **guard clauses and early returns**. 
Designs that use polymorphism can be easier to read and maintain, and express their intent more clearly. 
But it's not always easy to make the transition, especially when we have else in our back pocket. 
So as part of this exercise, you're not allowed to use else.

The design pattern [Strategy](http://en.wikipedia.org/wiki/Strategy_pattern) (or its special case [Null Object](http://en.wikipedia.org/wiki/Null_Object_pattern) pattern) is one of the examples of using polymorphism to avoid branching.

> **Null Object Pattern falacy**
>
> People normally tend to use Null Object pattern when they face a problem similar to this one:
>
>     $this->manager->getConfig()->getName();
>
> In a case where `getConfig()` returns null, you receive a fatal error from PHP while trying to call a method over a null value.
> By looking at this sample, it is not only hurting [Law of Demeter](http://en.wikipedia.org/wiki/Law_of_Demeter), but also a very poor design that may receive `null` values, but the code is not safe enough to handle this situation.
> 
> A dummy approach is to use Null Object pattern to address this issue, but it tends to hurt more than solve. 
> Null Objects are great to be used as part of testing, but not in production code. 
> When it is mentioned it hurts, it is because you're actually masking underlying problems such as:
>
> * Encapsulation problem
> * Hard to debug and handle exceptions
> * Codebase needs to be structured to deal with NullObject
> * Hard to read and understand

#### Benefits:

- Prevents code duplication
- Increases readability
- Reduce [cyclomatic complexity](http://en.wikipedia.org/wiki/Cyclomatic_complexity)


### Rule #3: Wrap primitive types and strings

- Status: **Cannot implement**

An ``integer`` on its own is just a scalar with no meaning. 
When a method takes an integer as a parameter, the method name needs to do all the work of expressing the intent. 
If the same method takes an hour as a parameter, it's much easier to see what's happening. 

Small objects like this can make programs more maintainable, since it isn't possible to pass a year to a method that takes an hour parameter. 
With a primitive variable, the compiler can't help you write semantically correct programs. 
With an object, even a small one, you are giving both the compiler and the programmer additional information about what the value is and why it is being used.

So go ahead and wrap primitives whenever feasible. 
Small objects will also give you an obvious place to put behavior that otherwise would have been littered around other classes.

> This rule will be regarded as a guideline, as opposed to a strict rule. So basically, if a variable of a primitive type has behavior, consider creating a class for it.

#### Benefits:

- Type hinting
- Better encapsulation
- Prevent code duplication


### Rule #4: Use only object operator per line

- Status: **Implemented**

> **NOTE**
>
> When considering class own's members (`$this`), we have to accept 2 object operators per statement/line. 
> Otherwise, this would be considered invalid:
>
> * $this->property->method();

When object operators are connected, your object is digging deeply into another object (or even a series of objects). 
These multiple dots indicate that you're conceptually violating encapsulation. 
Try asking that object to do something for you, rather than poking around its insides. 
A major part of encapsulation is not reaching across class boundaries into types that you shouldn't necessarily know about.

Also, multiple dots in a single line of code might result in several issues when it comes to debugging, logging and exception handling, since you won't be able to isolate the bug, or the atomic action, properly.

The [Law of Demeter](http://en.wikipedia.org/wiki/Law_of_Demeter) ("Only talk to your friends") is a good place to start, but think about it this way: You can play with your toys, toys that you make and toys that someone gives you. 
You don't ever, ever play with your toy's toys.

> This rule got adapted to accept chaining the same object via [Fluent Interfaces](http://en.wikipedia.org/wiki/Fluent_interface) is fine, but please apply this technique carefully, as described in this [blog post](http://devzone.zend.com/article/1362).

#### Benefits:

* Law of Demeter
* Readability
* Increases testability
* Easier to debug


### Rule #5: Do not abbreviate

- Status: **Partially implemented**

It's often tempting to abbreviate in the names of classes, methods or variables. Resist the temptation. Abbreviations can be confusing, and the tend to hide larger problems.

Think about why you want to abbreviate.

* Is it because you are typing the same word over and over again? If that's the case, perhaps your method is used too heavily, and you're missing opportunities to remove duplication.
* Is it because your method names are getting long? This might be a sign of a misplaced responsibility or a missing class.

Try to keep class and method names to one to two words, and avoid names that duplicate the context. 
If the class is an `Order`, the method doesn't need to be called shipOrder()`. 
Simply name the method `ship()` so that clients call `$order->ship()` - a simple and clear representation of what's happening.

For this exercise, all members should have a name that is one or two words, with no abbreviations.

#### Benefits:

* Increases readability
* Better communication
* Maintainability
* Good problem indicator of encapsulation problem and code duplication


### Rule #6: Keep your classes small

- Status: **Partially Implemented**

This means no class that's more than 200 lines, and no package that's more than 15 classes.

The original rule by Jeff Bay dictated 50-line classes. 
However, there was nothing in that rule related to inline comments, doc-blocks, blank lines or control structure closing lines. 
Thus, it makes sense for our team to extend this rule in order to allow for 100 lines of code per class, including all extra metadata mentioned here, which can easily take over 50% of file length.

Classes of more than 200 lines usually do more than one thing, which makes them harder to understand and harder to reuse. 
200-line classes have the added benefit of being visible with little scrolling, which makes them easier to grasp quickly.
Additionally, methods that are bigger than 20 lines of code also indicates they are doing more than a single atomic operation. 
Consider also up to 10 methods per class.

What's challenging about creating such small classes is that there are often groups of behaviors that make logical sense together. 
This is where we need to leverage packages. 
As your classes become smaller and have fewer responsibilities and as you limit package size, you'll start to see that packages represent clusters of related classes that work together to achieve a goal. 
Packages, like classes, should be cohesive and have a purpose. 
Keeping those packages small forces them to have real identity.

In a nutshell, we want a higher number of smaller packages, with skinny classes inside them.

#### Benefits:

* Single Responsibility Principle ("S" in SOLID)
* Clear methods and their objectives
* Better code segregation
* Cleaner namespaces


### Rule #7: Do not use classes with several instance variables

- Status: **Implemented**

Decomposing objects from a set of attributes into a hierarchy of collaborating objects leads much more directly to an effective object model.
Prior to understanding this rule, one can spend many hours trying to follow data flows through large objects.
It is possible to tweeze out an object model, but it is a painstaking process to understand the related groups of behavior and see the result.
In contrast, the recursive application of this rule has led to a very quick decomposition of complex large objects into a much simpler objects.
Behavior naturally follows the instance variables into the appropriate place - the compiler and the rules on encapsulation won't allow otherwise.
If you get stuck, work downward by splitting objects into related halves or upward by picking any two instance variables and making an object out of them.

The original rule of Jeff Bay kept any given entity from having more than 2 class instance attributes. However, this seems to be a bit over the edge, and not really practical measure.
Probably, a maximum number of 5 instance variables will equally contribute to higher levels of cohesiveness and encapsulation.
The majority of rules in this exercise also contribute to the same set of positive outcomes.

#### Benefits:

* Single Responsibility Principle ("S" in SOLID)
* Loose coupling
* Better encapsulation
* Testability


### Rule #8: Use first-class collections

- Status: **Implemented**

The application of this rule is simple: any class that contains a collection should contain no other member variables.

A collection gets wrapped in its own class, so now behaviors related to the collection have a home. 
You may find that filters become part of this new class. Filters may also become function objects in their own right. 
Also, your new class can handle activities such as joining two group together or applying a rule to each element of the group. 
This is an obvious extension of the rule "Do not use classes with several instance variables" (previous topic), but it is important for its own sake as well. 
A collection is really a type of very useful primitive. It has many behaviors but little semantic intent or clues for either the next programmer or the maintainer.

#### Benefits:

* Single Responsibility Principle ("S" in SOLID)
* Operations over collections are implemented inside of collection
* Easy to group collections without bothering about its member behavior
* Filtering, ordering, mapping and merging are good method examples


### Rule #9: Use getters and setters

- Status: **Implemented**

The application of this rule is simple: any class should not contain public properties.

#### Benefits:

* Open/Close Principle ("O" in SOLID)
* Operation injection
* Encapsulation of transformations
