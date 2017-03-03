<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\NamingConventions;

use ObjectCalisthenics\AbstractIdentifierLengthSniff;
use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Sniff;

final class FunctionNameLengthSniff extends AbstractIdentifierLengthSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * @var string
     */
    protected $tokenString = 'function';

    /**
     * @var int
     */
    protected $tokenTypeLengthFactor = 0;

    protected function isValid(PHP_CodeSniffer_File $file, int $position): bool
    {
        $previousTFunctionPosition = $file->findPrevious(T_FUNCTION, ($position - 1), null, false, null, true);
        if ($previousTFunctionPosition === false) {
            return false;
        }

        $textAfterTFunction = $file->getTokensAsString(
            $previousTFunctionPosition + 1,
            $position - $previousTFunctionPosition - 1
        );

        return trim($textAfterTFunction) === '';
    }
}
