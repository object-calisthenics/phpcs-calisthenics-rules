<?php declare(strict_types=1);

namespace ObjectCalisthenics\Helper\Slevomat;

use PHP_CodeSniffer\Files\File;
use SlevomatCodingStandard\Helpers\TokenHelper;

/**
 * Mirror to SlevomatCodingStandard\Helpers\PropertyHelper
 * until CodeSniffer 3.0 compatible version is ready
 */
final class PropertyHelper
{
    public static function isProperty(File $codeSnifferFile, int $variablePointer): bool
    {
        $propertyDeterminingPointer = TokenHelper::findPreviousExcluding(
            $codeSnifferFile,
            array_merge([T_STATIC], TokenHelper::$ineffectiveTokenCodes),
            $variablePointer - 1
        );

        return in_array($codeSnifferFile->getTokens()[$propertyDeterminingPointer]['code'], [
            T_PRIVATE,
            T_PROTECTED,
            T_PUBLIC,
            T_VAR,
        ], true);
    }
}
