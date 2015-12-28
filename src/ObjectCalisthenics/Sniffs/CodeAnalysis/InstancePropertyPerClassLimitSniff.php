<?php

namespace ObjectCalisthenics\Sniffs\CodeAnalysis;

use ObjectCalisthenics\AbstractPropertyTypePerClassLimitSniff;
use PHP_CodeSniffer_Sniff;

/**
 * Instance property per class limit, part of "Do not use classes with several instance variables" OC rule.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
final class InstancePropertyPerClassLimitSniff extends AbstractPropertyTypePerClassLimitSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * {@inheritdoc}
     */
    protected $trackedMaxCount = 2147483647;

    /**
     * {@inheritdoc}
     */
    protected $untrackedMaxCount = 5;

    /**
     * {@inheritdoc}
     */
    protected function getTrackedPropertyTypeList()
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

    /**
     * {@inheritdoc}
     */
    protected function getUntrackedPropertyType()
    {
        return 'object instance';
    }
}
