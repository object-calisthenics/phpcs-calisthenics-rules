<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\NamingConventions;

use ObjectCalisthenics\AbstractIdentifierLengthSniff;
use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Sniff;

/**
 * Function name length sniffer, part of "Do not abbreviate" object calisthenics rule.
 */
final class FunctionLengthSniff extends AbstractIdentifierLengthSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * @var string
     */
    protected $tokenString = 'function';

    /**
     * @var int
     */
    protected $tokenTypeLengthFactor = 0;

    protected function isValid(PHP_CodeSniffer_File $phpcsFile, int $stackPtr): bool
    {
        $previousTFunctionPosition = $phpcsFile->findPrevious(T_FUNCTION, ($stackPtr - 1), null, false, null, true);
        if ($previousTFunctionPosition === false) {
            return false;
        }

        $textAfterTFunction = $phpcsFile->getTokensAsString(
            $previousTFunctionPosition + 1,
            $stackPtr - $previousTFunctionPosition - 1
        );

        return trim($textAfterTFunction) === '';
    }
}
