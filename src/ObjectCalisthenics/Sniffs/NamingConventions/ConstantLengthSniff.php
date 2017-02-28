<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\NamingConventions;

use ObjectCalisthenics\AbstractIdentifierLengthSniff;
use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Sniff;

/**
 * Constant name length sniffer, part of "Do not abbreviate" object calisthenics rule.
 */
final class ConstantLengthSniff extends AbstractIdentifierLengthSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * @var string
     */
    protected $tokenString = 'constant';

    /**
     * @var int
     */
    protected $tokenTypeLengthFactor = 0;

    protected function isValid(PHP_CodeSniffer_File $phpcsFile, int $stackPtr): bool
    {
        return $phpcsFile->findPrevious(T_CONST, ($stackPtr - 1), null, false, null, true) !== false;
    }
}
