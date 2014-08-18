# PHPCS-Calisthenics-Rules

A [PHP Code Sniffer](http://pear.php.net/package/PHP_CodeSniffer/) standard to verify Object Calisthenics rules.


## Installation

If you prefer using [Composer](http://getcomposer.org/) you can easily install Object Calisthenics rules system-wide with the following command:

    composer global require "object-calisthenics/phpcs-calisthenics-rules=*"

Make sure you have `~/.composer/vendor/bin/` in your PATH.

Or alternatively, include a dependency for `object-calisthenics/phpcs-calisthenics-rules` in your `composer.json` file. For example:

    {
        "require-dev": {
            "object-calisthenics/phpcs-calisthenics-rules": "dev-master"
        }
    }


# Object Calisthenics

[The ThoughtWorks Anthology](http://pragprog.com/book/twa/thoughtworks-anthology), a technical book published by [The Pragmatic Programmers](http://pragprog.com), introduced a technique called [Object Calisthenics](http://www.xpteam.com/jeff/writings/objectcalisthenics.rtf), proposed by [Jeff Bay](http://www.xpteam.com/jeff), who used to be the Technology Principal at [ThoughtWorks](http://www.thoughtworks.com). 
The **adapted excerpts** present the author's motivation, as well as the proposed exercise and rules, ported to PHP language.


## Motivation

We've all seen poorly written code that's hard to understand, test and maintain.
Object-oriented programming promised to save us from our old procedural code, allowing us to write software incrementally, reusing as we go. But sometimes it seems like we're just chasing down the same old complex, coupled designs in Java that we had in C.

Good object-oriented design can be hard to learn. Transitioning from procedural development to object-oriented design requires a major shift in thinking that is more difficult than it seems. Many developers assume they're doing a good job with OO design, when in reality they're unconsciously stuck in procedural habits that are hard to break. It doesn't help that many examples and best practices encourage poor OO design in the name of performance or the simple weight of history.

The core concepts behind good design are well understood. [Alan Shalloway](http://www.netobjectives.com/bio-alan-shalloway) has suggested that seven code qualities matter: cohesion, loose coupling, zero duplication, encapsulation, testability, readability and focus. Yet it's hard to put those concepts into practice. It is one thing to understand that encapsulation means hiding data, implementation, type, design, or construction. It's another thing altogether to design code that implements encapsulation well.


## Proposed Exercise

Code a project using far stricter coding standards then you've ever used in your life. In this section you'll find rules that will help push you into writing code that is almost required to be object-oriented. This will allow you to make better decisions and give you more and better options when confronted with the problems of your day job.

By suspending disbelief and rigidly applying these rules on a project, you'll start to see a significantly different approach to designing software. Once you've written the core components, the exercise is done, and you can relax and go back to using these rules as guidelines.

This is a hard exercise, especially because many of these rules are not universally applicable. The fact is that sometimes classes are little more than 100 lines. But there's great value in thinking about what would have to happen to move those responsibilities into real, first-class objects of their own. It's developing this type of thinking that's the real value of the exercise. So, stretch the limits of what you imagine is possible, and see whether you start thinking about your code in a new way.


## Proposed Rules


### Rule #1: Only one level of indentation

- Status: **Implemented**

Ever stare at a big old method wondering where to start? A giant method lacks cohesiveness. 
One guideline is to limit method length to five lines, but that kind of transition can be daunting if your code is littered with 500-line monsters. Instead, try to ensure that each method does exactly one thing - one control structure or one block of statements per method. If you've got nested control structures in a method, you're working at multiple levels of abstraction, and that means you're doing more than one thing.

As you work with methods that do exactly one thing, expressed within classes doing exactly one thing, your code begins to change. As each unit in your application becomes smaller, your level of re-use will start to rise exponentially. It can be difficult to spot opportunities for reuse within a method that has five responsibilities and is implemented in 100 lines. A three-line method that manages the state of a single object in a given context is usable in many different contexts.

#### Benefits:

- Single Responsibility Principle ("S" in SOLID)
- Benefits reusability


### Do not use "else" keyword

- Status: **Implemented**

Every programmer understands the **if/else** construct. It's built into nearly every programming language, and simple conditional logic is easy for anyone to understand.  Nearly every programmer has seen a nasty nested conditional that's impossible to follow, or a case statement that goes on for pages.  Even worse, it is all too easy to simply add another branch to an existing conditional rather than factoring to a better solution. Conditionals are also a frequent source of duplication.

When a given method provides one behavior for the **if** branch, and another behavior for the **else** branch, then it means that this particular method is not cohesive. It has got more than one responsibility, dealing with different behaviors.

Object-oriented languages give you a powerful tool - [Polymorphism](http://en.wikipedia.org/wiki/Type_polymorphism) - for handling complex conditional cases. Simple cases can be replaced with **guard clauses and early returns**. Designs that use polymorphism can be easier to read and maintain, and express their intent more clearly. But it's not always easy to make the transition, especially when we have else in our back pocket. So as part of this exercise, you're not allowed to use else.

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
> A dummy approach is to use Null Object pattern to address this issue, but it tends to hurt more than solve. Null Objects are great to be used as part of testing, but not in production code. When I mentioned it hurts, it is because you're actually masking underlying problems such as:
>
> * Encapsulation problem
> * Hard to debug and handle exceptions
> * Codebase needs to be structured to deal with NullObject
> * Hard to read and understand

#### Benefits:

- Prevents code duplication
- Increases readability
- Reduce [cyclomatic complexity](http://en.wikipedia.org/wiki/Cyclomatic_complexity)


### Wrap primitive types and strings

- Status: **Cannot implement**

An ``integer`` on its own is just a scalar with no meaning. When a method takes an integer as a parameter, the method name needs to do all the work of expressing the intent. If the same method takes an hour as a parameter, it's much easier to see what's happening. 

Small objects like this can make programs more maintainable, since it isn't possible to pass a year to a method that takes an hour parameter. With a primitive variable, the compiler can't help you write semantically correct programs. With an object, even a small one, you are giving both the compiler and the programmer additional information about what the value is and why it is being used.

So go ahead and wrap primitives whenever feasible. Small objects will also give you an obvious place to put behavior that otherwise would have been littered around other classes.

> This rule will be regarded as a guideline, as opposed to a strict rule. So basically, if a variable of a primitive type has behavior, consider creating a class for it.
