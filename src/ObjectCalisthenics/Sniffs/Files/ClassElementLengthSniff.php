<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\Files;

use ObjectCalisthenics\AbstractDataStructureLengthSniff;
use PHP_CodeSniffer\Sniffs\Sniff;

final class ClassElementLengthSniff extends AbstractDataStructureLengthSniff implements Sniff
{
    /**
     * @var int
     */
    public $maxLength = 200;

    /**
     * @return int[]
     */
    public function register(): array
    {
        return [T_CLASS, T_INTERFACE, T_TRAIT];
    }
}
