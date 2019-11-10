<?php declare(strict_types=1);

namespace ObjectCalisthenics\Helper\Structure;

use PHP_CodeSniffer\Files\File;

final class StructureMetrics
{
    public static function getStructureLengthInLines(File $file, int $position): int
    {
        $tokens = $file->getTokens();
        $token = $tokens[$position];

        // Skip function without body.
        if (! isset($token['scope_opener'])) {
            return 0;
        }

        $firstToken = $tokens[$token['scope_opener']];
        $lastToken = $tokens[$token['scope_closer']];

        return $lastToken['line'] - $firstToken['line'];
    }
}
