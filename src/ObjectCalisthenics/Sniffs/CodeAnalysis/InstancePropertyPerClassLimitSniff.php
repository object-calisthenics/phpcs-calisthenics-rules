<?php

namespace ObjectCalisthenics\Sniffs\CodeAnalysis;

use ObjectCalisthenics\AbstractPropertyTypePerClassLimitSniff;

/**
 * Instance property per class limit, part of "Do not use classes with several instance variables" OC rule.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
final class InstancePropertyPerClassLimitSniff extends AbstractPropertyTypePerClassLimitSniff
{
    /**
     * {@inheritdoc}
     */
    public $trackedMaxCount = 2147483647;

    /**
     * {@inheritdoc}
     */
    public $untrackedMaxCount = 5;

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
