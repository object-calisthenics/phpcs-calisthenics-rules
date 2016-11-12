<?php

declare(strict_types=1);

namespace ObjectCalisthenics\Helper\Structure;

use PHP_CodeSniffer_File;

final class StructureMetrics
{
    public static function getStructureLengthInLines(PHP_CodeSniffer_File $phpcsFile, int $stackPtr) : int
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];

        // Skip function without body.
        if (isset($token['scope_opener']) === false) {
            return 0;
        }

        $firstToken = $tokens[$token['scope_opener']];
        $lastToken = $tokens[$token['scope_closer']];

        return $lastToken['line'] - $firstToken['line'];
    }
}
