<?php

/**
 * Instance property per class limit, part of "Do not use classes with several instance variables" OC rule.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
class ObjectCalisthenics_Sniffs_CodeAnalysis_InstancePropertyPerClassLimitSniff extends ObjectCalisthenics_PropertyTypePerClassLimitSniff
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
        return array(
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
        );
    }

    protected function getUntrackedPropertyType()
    {
        return 'object instance';
    }
}
