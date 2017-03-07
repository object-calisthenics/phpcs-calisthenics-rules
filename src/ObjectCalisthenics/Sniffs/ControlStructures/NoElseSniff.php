<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\ControlStructures;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

final class NoElseSniff implements Sniff
{
    /**
     * @return int[]
     */
    public function register(): array
    {
        return [T_ELSE, T_ELSEIF];
    }

    /**
     * @param File $file
     * @param int  $position
     */
    public function process(File $file, $position): void
    {
        $file->addError('Do not use "else" or "elseif" tokens', $position, self::class);
    }
}
