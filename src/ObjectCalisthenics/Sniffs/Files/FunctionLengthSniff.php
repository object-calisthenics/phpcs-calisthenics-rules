<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\Files;

use ObjectCalisthenics\AbstractDataStructureLengthSniff;
use PHP_CodeSniffer_Sniff;

/**
 * Function/class method length sniffer,
 * part of "Keep your classes small" object calisthenics rule.
 */
final class FunctionLengthSniff extends AbstractDataStructureLengthSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * @var int
     */
    protected $maxLength = 20;

    public function register(): array
    {
        return [T_FUNCTION];
    }
}
