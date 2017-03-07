<?php declare(strict_types=1);

namespace ObjectCalisthenics\Helper;

use Nette\Utils\Strings;
use PHP_CodeSniffer\Files\File;

final class Naming
{
    public static function getElementName(File $file, int $position): string
    {
        $name = $file->getTokens()[$position]['content'];

        if (Strings::startsWith($name, '$')) {
            return trim($name, '$');
        }

        $namePosition = $file->findNext(T_STRING, $position, $position + 3);

        return $file->getTokens()[$namePosition]['content'];
    }
}
