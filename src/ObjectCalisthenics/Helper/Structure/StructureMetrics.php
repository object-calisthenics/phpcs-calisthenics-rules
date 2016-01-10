<?php

namespace ObjectCalisthenics\Helper\Structure;

use PHP_CodeSniffer_File;

final class StructureMetrics
{
    /**
     * @param PHP_CodeSniffer_File $phpcsFile
     * @param int                  $stackPtr
     *
     * @return int
     */
    public static function getStructureLengthInLines(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
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
