<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\ControlStructures;

use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Sniff;

/**
 * Do not use "else" or "elseif" tokens.
 */
final class NoElseSniff implements PHP_CodeSniffer_Sniff
{
    public function register(): array
    {
        return [T_ELSE, T_ELSEIF];
    }

    /**
     * @param PHP_CodeSniffer_File $file
     * @param int                  $position
     */
    public function process(PHP_CodeSniffer_File $file, $position): void
    {
        $file->addError('Do not use "else" or "elseif" tokens', $position);
    }
}
