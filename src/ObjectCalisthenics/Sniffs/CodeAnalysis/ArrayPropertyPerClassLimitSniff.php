<?php

declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\CodeAnalysis;

use ObjectCalisthenics\AbstractPropertyTypePerClassLimitSniff;
use PHP_CodeSniffer_Sniff;

/**
 * Array property per class limits, part of "Use first class collections" OC rule.
 */
final class ArrayPropertyPerClassLimitSniff extends AbstractPropertyTypePerClassLimitSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * @var int
     */
    protected $trackedMaxCount = 1;

    /**
     * @var int
     */
    protected $untrackedMaxCount = 0;

    protected function getTrackedPropertyTypeList(): array
    {
        return ['array'];
    }
}
