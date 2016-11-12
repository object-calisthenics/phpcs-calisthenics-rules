<?php

declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\Files;

use ObjectCalisthenics\AbstractDataStructureLengthSniff;
use PHP_CodeSniffer_Sniff;

/**
 * Class, interface and trait length sniffer,
 * part of "Keep your classes small" object calisthenics rule.
 */
final class ClassElementLengthSniff extends AbstractDataStructureLengthSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * @var int
     */
    protected $maxLength = 200;

    public function register() : array
    {
        return [T_CLASS, T_INTERFACE, T_TRAIT];
    }
}
