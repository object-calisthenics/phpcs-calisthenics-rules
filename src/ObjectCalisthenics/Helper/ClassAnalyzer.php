<?php declare(strict_types=1);

namespace ObjectCalisthenics\Helper;

use ObjectCalisthenics\Helper\DocBlock\MemberComment;
use PHP_CodeSniffer_File;

final class ClassAnalyzer
{
    /**
     * @var array
     */
    private static $propertyList;

    public static function getClassProperties(PHP_CodeSniffer_File $file, int $stackPtr): array
    {
        $tokens = $file->getTokens();
        $token = $tokens[$stackPtr];
        $pointer = $token['scope_opener'];

        self::$propertyList = [];

        while (($pointer = $file->findNext(T_VARIABLE, ($pointer + 1), $token['scope_closer'])) !== false) {
            self::extractPropertyIfFound($file, (int) $pointer);
        }

        return self::$propertyList;
    }

    private static function extractPropertyIfFound(PHP_CodeSniffer_File $phpcsFile, int $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $property = $tokens[$stackPtr];

        // Is it a property or a random variable?
        if (!(count($property['conditions']) === 1 && in_array(reset($property['conditions']), [T_CLASS, T_TRAIT]))) {
            return;
        }

        if ($comment = MemberComment::getMemberComment($phpcsFile, $stackPtr)) {
            self::$propertyList[] = [
                'type' => $comment,
            ];
        }
    }
}
