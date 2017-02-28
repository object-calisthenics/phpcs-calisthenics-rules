<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\Files;

use ObjectCalisthenics\AbstractDataStructureLengthSniff;
use PHP_CodeSniffer_Sniff;

final class ClassElementLengthSniff extends AbstractDataStructureLengthSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * @var int
     */
    public $maxLength = 200;

    public function register(): array
    {
        return [T_CLASS, T_INTERFACE, T_TRAIT];
    }
}
