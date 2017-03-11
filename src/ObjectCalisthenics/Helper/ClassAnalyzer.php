<?php declare(strict_types=1);

namespace ObjectCalisthenics\Helper;

use Exception;
use ObjectCalisthenics\Helper\DocBlock\MemberComment;
use PHP_CodeSniffer\Files\File;

final class ClassAnalyzer
{
    /**
     * @var array
     */
    private static $propertyList;

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
        $tokens = $file->getTokens();
        $property = $tokens[$position];

        // Is it a property or a random variable?
        if (!(count($property['conditions']) === 1 && in_array(reset($property['conditions']), [T_CLASS, T_TRAIT]))) {
            return;
        }

        if ($comment = MemberComment::getMemberComment($file, $position)) {
            self::$propertyList[] = [
                'type' => $comment,
            ];
        }
    }

    private static function ensureIsClassTraitOrInterface(File $file, int $position): void
    {
        $token = $file->getTokens()[$position];

        if (!in_array($token['code'], [T_CLASS, T_INTERFACE, T_TRAIT])) {
            throw new Exception(
                sprintf(
                    'Must be class, interface or trait. "%s" given.',
                    ltrim($token['type'], 'T_')
                )
            );
        }
    }
}
