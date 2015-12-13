<?php

namespace ObjectCalisthenics\Sniffs\CodeAnalysis;

use ObjectCalisthenics\AbstractPropertyTypePerClassLimitSniff;

/**
 * Array property per class limits, part of "Use first class collections" OC rule.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
final class ArrayPropertyPerClassLimitSniff extends AbstractPropertyTypePerClassLimitSniff
{
    /**
     * {@inheritdoc}
     */
    protected $trackedMaxCount = 1;

    /**
     * {@inheritdoc}
     */
    protected $untrackedMaxCount = 0;

    /**
     * {@inheritdoc}
     */
    protected function getTrackedPropertyTypeList()
    {
        return ['array'];
    }
}
