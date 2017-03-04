<?php declare(strict_types=1);

namespace ObjectCalisthenics\Helper;

use PHP_CodeSniffer_File;

final class Naming
{
    public static function getElementName(PHP_CodeSniffer_File $file, int $position): string
    {
        $functionNamePosition = $file->findNext(T_STRING, $position, $position + 3);

        return $file->getTokens()[$functionNamePosition]['content'];
    }
}
