# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

PRs and issues are linked, so you can find more about it. Thanks to [ChangelogLinker](https://github.com/Symplify/ChangelogLinker).

<!-- changelog-linker -->

## [v3.6.0]

- [#94] Bump to PHP 7.2, Thanks to [@TomasVotruba]
- [#92] Per Line -> Per Statement, Thanks to [@afilina]

## [v3.5.1] - 2019-05-15

- [#89] Allow the usage of nette/utils ^3.0, Thanks to [@jeromegamez]

## [v3.5.0] - 2019-03-19

- [#87] Update slevomat/coding-standard to version 5.0, Thanks to [@jeroennoten]
- [#88] Add PHP 7.3 to Travis, Thanks to [@jeroennoten]

## [v3.4.0] - 2018-11-17

### Changed

- [#84] Bump dependencies, Thanks to [@TomasVotruba]
- [#81] README: put examples with code right into README to prevent jumping to miss-located config anchors, Thanks to [@TomasVotruba]

## [v3.3.0] - 2018-07-22

### Added

- [#80] Add `allowedClasses` to `NoSetterSniff`, Thanks to [@TomasVotruba]

### Changed

- [#79] Bump composer versions, Thanks to [@TomasVotruba]

## [v3.2.1] - 2018-05-12

- [#78] Decouple own config to allow importing the set, Thanks to [@TomasVotruba]

## [v3.2.0] - 2018-04-05

- [#77] bump to Symplify 4, Thanks to [@TomasVotruba]

## [v3.1.0] - 2017-10-19

- [#68] Replace example for Rule 2, Thanks to [@roukmoute]
- [#71] Small typo fixes, Thanks to [@noplanman]
- [#72] Cleanup and dependency updates, Thanks to [@TomasVotruba]

## [v3.0.0] - 2017-06-17

### Added

- [#64] [tests] use AbstractSniffRunner, no custom; bump to CodeSniffer 3.0, Thanks to [@TomasVotruba]
- [#58] Easy coding standard enabled + simplify and unite sniff structure + move rule 8 , Thanks to [@TomasVotruba]
- [#51] Add minimal OneObjectOperatorPerLine config example, Thanks to [@UFOMelkor]
- [#50] Add few tests, Thanks to [@TomasVotruba]
- [#47] Make more sniff classes configurable, Thanks to [@TomasVotruba]
- [#46] Make rules configurable, Thanks to [@TomasVotruba]
- [#37] Ignore default keyword for switch/case, Thanks to [@roukmoute]

### Changed

- [#62] Bump to Codesniffer 3, Thanks to [@TomasVotruba]
- [#63] Changed Composer package type to `phpcodesniffer-standard`, Thanks to [@frenck]
- [#65] Polishing before release, Thanks to [@TomasVotruba]
- [#44] Cleanup README, bump to PHP 7.1, PHPUnit 6.0, drop unused code, Thanks to [@TomasVotruba]
- [#49] Bump to Code Sniffer 3-RC, Thanks to [@TomasVotruba]
- [#59] README: first changes, link to ruleset.xml settings, drop duplication, Thanks to [@TomasVotruba]

### Fixed 

- [#56] Fixed README, Thanks to [@phux]
- [#55] Fixed error message for MaxNestingLevelSniff, Thanks to [@phux]
- [#53] Fix False positive (OneObjectOperatorPerLine) for property access within a class, Thanks to [@UFOMelkor]
- [#42] Class and function length: false positives, Thanks to [@UFOMelkor]

### Removed

- [#45] Drop rule 4, it is way too strict in practise, Thanks to [@TomasVotruba]

[#79]: https://github.com/object-calisthenics/phpcs-calisthenics-rules/pull/79
[#78]: https://github.com/object-calisthenics/phpcs-calisthenics-rules/pull/78
[#77]: https://github.com/object-calisthenics/phpcs-calisthenics-rules/pull/77
[#72]: https://github.com/object-calisthenics/phpcs-calisthenics-rules/pull/72
[#71]: https://github.com/object-calisthenics/phpcs-calisthenics-rules/pull/71
[#70]: https://github.com/object-calisthenics/phpcs-calisthenics-rules/pull/70
[#68]: https://github.com/object-calisthenics/phpcs-calisthenics-rules/pull/68
[#65]: https://github.com/object-calisthenics/phpcs-calisthenics-rules/pull/65
[#64]: https://github.com/object-calisthenics/phpcs-calisthenics-rules/pull/64
[#63]: https://github.com/object-calisthenics/phpcs-calisthenics-rules/pull/63
[#62]: https://github.com/object-calisthenics/phpcs-calisthenics-rules/pull/62
[#59]: https://github.com/object-calisthenics/phpcs-calisthenics-rules/pull/59
[#58]: https://github.com/object-calisthenics/phpcs-calisthenics-rules/pull/58
[#56]: https://github.com/object-calisthenics/phpcs-calisthenics-rules/pull/56
[#55]: https://github.com/object-calisthenics/phpcs-calisthenics-rules/pull/55
[#53]: https://github.com/object-calisthenics/phpcs-calisthenics-rules/pull/53
[#51]: https://github.com/object-calisthenics/phpcs-calisthenics-rules/pull/51
[#50]: https://github.com/object-calisthenics/phpcs-calisthenics-rules/pull/50
[#49]: https://github.com/object-calisthenics/phpcs-calisthenics-rules/pull/49
[#47]: https://github.com/object-calisthenics/phpcs-calisthenics-rules/pull/47
[#46]: https://github.com/object-calisthenics/phpcs-calisthenics-rules/pull/46
[#45]: https://github.com/object-calisthenics/phpcs-calisthenics-rules/pull/45
[#44]: https://github.com/object-calisthenics/phpcs-calisthenics-rules/pull/44
[#42]: https://github.com/object-calisthenics/phpcs-calisthenics-rules/pull/42
[#37]: https://github.com/object-calisthenics/phpcs-calisthenics-rules/pull/37
[@roukmoute]: https://github.com/roukmoute
[@phux]: https://github.com/phux
[@noplanman]: https://github.com/noplanman
[@frenck]: https://github.com/frenck
[@UFOMelkor]: https://github.com/UFOMelkor
[@TomasVotruba]: https://github.com/TomasVotruba
[@GaryJones]: https://github.com/GaryJones
[#80]: https://github.com/object-calisthenics/phpcs-calisthenics-rules/pull/80
[v3.3.0]: https://github.com/object-calisthenics/phpcs-calisthenics-rules/compare/v3.2.1...v3.3.0
[v3.2.1]: https://github.com/object-calisthenics/phpcs-calisthenics-rules/compare/v3.2.0...v3.2.1
[v3.2.0]: https://github.com/object-calisthenics/phpcs-calisthenics-rules/compare/v3.1.0...v3.2.0
[v3.1.0]: https://github.com/object-calisthenics/phpcs-calisthenics-rules/compare/v3.0.0...v3.1.0
[#88]: https://github.com/object-calisthenics/phpcs-calisthenics-rules/pull/88
[#87]: https://github.com/object-calisthenics/phpcs-calisthenics-rules/pull/87
[#84]: https://github.com/object-calisthenics/phpcs-calisthenics-rules/pull/84
[#81]: https://github.com/object-calisthenics/phpcs-calisthenics-rules/pull/81
[@jeroennoten]: https://github.com/jeroennoten
[#94]: https://github.com/object-calisthenics/phpcs-calisthenics-rules/pull/94
[#92]: https://github.com/object-calisthenics/phpcs-calisthenics-rules/pull/92
[#89]: https://github.com/object-calisthenics/phpcs-calisthenics-rules/pull/89
[v3.6.0]: https://github.com/object-calisthenics/phpcs-calisthenics-rules/compare/v3.5.1...v3.6.0
[v3.5.1]: https://github.com/object-calisthenics/phpcs-calisthenics-rules/compare/v3.5.0...v3.5.1
[@jeromegamez]: https://github.com/jeromegamez
[@afilina]: https://github.com/afilina