<?php

namespace ObjectCalisthenics\Sniffs\CodeAnalysis;

use ObjectCalisthenics\PropertyTypePerClassLimitSniff;

/**
 * Array property per class limist, part of "Use first class collections" OC rule.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
final class ArrayPropertyPerClassLimitSniff extends PropertyTypePerClassLimitSniff
{
    /**
     * {@inheritdoc}
     */
    public $trackedMaxCount = 1;

    /**
     * {@inheritdoc}
     */
    public $trackedAbsoluteMaxCount = 1;

    /**
     * {@inheritdoc}
     */
    public $untrackedAbsoluteMaxCount = 0;

    /**
     * {@inheritdoc}
     */
    protected function getTrackedPropertyTypeList()
    {
        return ['array'];
    }
}