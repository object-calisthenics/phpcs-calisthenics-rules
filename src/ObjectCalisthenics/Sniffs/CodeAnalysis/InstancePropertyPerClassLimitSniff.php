<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\CodeAnalysis;

use ObjectCalisthenics\AbstractPropertyTypePerClassLimitSniff;
use PHP_CodeSniffer_Sniff;

/**
 * Instance property per class limit, part of "Do not use classes with several instance variables" OC rule.
 */
final class InstancePropertyPerClassLimitSniff extends AbstractPropertyTypePerClassLimitSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * @var int
     */
    protected $trackedMaxCount = 100;

    /**
     * @var int
     */
    protected $untrackedMaxCount = 5;

    /**
     * @return string[]
     */
    protected function getTrackedPropertyTypeList(): array
    {
        return [
            'array',
            'bool',
            'boolean',
            'callable',
            'decimal',
            'double',
            'float',
            'int',
            'integer',
            'resource',
            'string',
        ];
    }
}
