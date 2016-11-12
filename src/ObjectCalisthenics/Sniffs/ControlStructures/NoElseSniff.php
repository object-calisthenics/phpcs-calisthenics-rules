<?php

declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\ControlStructures;

use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Sniff;

/**
 * Do not use "else" or "elseif" tokens.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
final class NoElseSniff implements PHP_CodeSniffer_Sniff
{
    public function register() : array
    {
        return [T_ELSE, T_ELSEIF];
    }

    /**
     * @param PHP_CodeSniffer_File $phpcsFile
     * @param int $stackPtr
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $phpcsFile->addError('Do not use "else" or "elseif" tokens', $stackPtr);
    }
}
