<?php declare(strict_types=1);

namespace ObjectCalisthenics\Helper;

use Nette\Utils\Strings;
use PHP_CodeSniffer\Files\File;

final class NamingHelper
{
    /**
     * @var string[]
     */
    private static $codeToTypeNameMap = [
        T_CONST => 'Constant',
        T_CLASS => 'Class',
        T_FUNCTION => 'Function',
        T_TRAIT => 'Trait',
    ];

    public static function getTypeName(File $file, int $position): string
    {
        $token = $file->getTokens()[$position];
        $tokenCode = $token['code'];
        if (isset(self::$codeToTypeNameMap[$tokenCode])) {
            return self::$codeToTypeNameMap[$tokenCode];
        }

        if ($token['code'] === T_VARIABLE) {
            if (PropertyHelper::isProperty($file, $position)) {
                return 'Property';
            }

            return 'Variable';
        }

        return '';
    }

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
