<?php declare(strict_types=1);

namespace ObjectCalisthenics\Helper;

use PHP_CodeSniffer\Files\File;

final class PropertyHelper
{
    public static function isProperty(File $file, int $variablePosition): bool
    {
        $propertyDeterminingPointer = $file->findPrevious(
            [T_STATIC, T_WHITESPACE, T_COMMENT],
            $variablePosition - 1,
            null,
            true
        );

        $propertyDeterminingPointerToken = $file->getTokens()[$propertyDeterminingPointer];
        $propertyDeterminingPointerCode = $propertyDeterminingPointerToken['code'];

        return in_array($propertyDeterminingPointerCode, [T_PRIVATE, T_PROTECTED, T_PUBLIC, T_VAR], true);
    }
}
