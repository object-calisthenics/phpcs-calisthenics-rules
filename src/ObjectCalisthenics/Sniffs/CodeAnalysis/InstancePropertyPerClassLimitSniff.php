<?php

namespace ObjectCalisthenics\Sniffs\CodeAnalysis;

use ObjectCalisthenics\PropertyTypePerClassLimitSniff;

/**
 * Instance property per class limit, part of "Do not use classes with several instance variables" OC rule.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
final class InstancePropertyPerClassLimitSniff extends PropertyTypePerClassLimitSniff
{
    /**
     * {@inheritdoc}
     */
    public $trackedMaxCount = 2147483647;

    /**
     * {@inheritdoc}
     */
    public $trackedAbsoluteMaxCount = 2147483647;

    /**
     * {@inheritdoc}
     */
    public $untrackedAbsoluteMaxCount = 5;

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
     * @return string
     */
    protected function getUntrackedPropertyType()
    {
        return 'object instance';
    }
}
