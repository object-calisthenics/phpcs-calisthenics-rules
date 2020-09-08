<?php declare(strict_types=1);

namespace ObjectCalisthenics\Helper;

use ObjectCalisthenics\Exception\NonClassTypeTokenTypeException;
use PHP_CodeSniffer\Files\File;

final class ClassAnalyzer
{
    /**
     * @var mixed[]
     */
    private static array $propertyList = [];

    public static function getClassMethodCount(File $file, int $position): int
    {
        self::ensureIsClassTraitOrInterface($file, $position);

        $methodCount = 0;
        $pointer = $position;

        while (($next = $file->findNext(T_FUNCTION, $pointer + 1)) !== false) {
            ++$methodCount;

            $pointer = $next;
        }

        return $methodCount;
    }

    public static function getClassPropertiesCount(File $file, int $position): int
    {
        return count(self::getClassProperties($file, $position));
    }

    /**
     * @return mixed[]
     */
    public static function getClassProperties(File $file, int $position): array
    {
        $tokens = $file->getTokens();
        $token = $tokens[$position];
        $pointer = $token['scope_opener'];

        self::$propertyList = [];

        while (($pointer = $file->findNext(T_VARIABLE, ($pointer + 1), $token['scope_closer'])) !== false) {
            self::extractPropertyIfFound($file, (int) $pointer);
        }

        return self::$propertyList;
    }

    private static function extractPropertyIfFound(File $file, int $position): void
    {
        if (PropertyHelper::isProperty($file, $position)) {
            self::$propertyList[] = $position;
        }
    }

    private static function ensureIsClassTraitOrInterface(File $file, int $position): void
    {
        $token = $file->getTokens()[$position];

        self::ensureIsClassLikeToken($token);
    }

    private static function ensureIsClassLikeToken(array $token): void
    {
        if (in_array($token['code'], [T_CLASS, T_INTERFACE, T_TRAIT], true)) {
            return;
        }

        $message = sprintf('Must be class, interface or trait. "%s" given.', ltrim($token['type'], 'T_'));
        throw new NonClassTypeTokenTypeException($message);
    }
}
