<?php declare(strict_types=1);

namespace ObjectCalisthenics\Helper;

use PHP_CodeSniffer\Files\File;

final class LegacyCompatibilityLayer
{
    public static function setupClassAliases(): void
    {
        if (! class_exists('PHP_CodeSniffer_File')) {
            class_alias(File::class, 'PHP_CodeSniffer_File');
        }
    }
}
