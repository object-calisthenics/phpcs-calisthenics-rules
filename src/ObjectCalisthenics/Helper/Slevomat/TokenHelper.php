<?php declare(strict_types = 1);

namespace ObjectCalisthenics\Helper\Slevomat;

use PHP_CodeSniffer\Files\File;

/**
 * Mirror to SlevomatCodingStandard\Helpers\PropertyHelper
 * until CodeSniffer 3.0 compatible version is ready
 */
final class TokenHelper
{

    /** @var mixed[] */
    public static $nameTokenCodes = [
        T_NS_SEPARATOR,
        T_STRING,
    ];

    /** @var mixed[] */
    public static $typeKeywordTokenCodes = [
        T_CLASS,
        T_TRAIT,
        T_INTERFACE,
    ];

    /** @var mixed[] */
    public static $ineffectiveTokenCodes = [
        T_WHITESPACE,
        T_COMMENT,
        T_DOC_COMMENT,
        T_DOC_COMMENT_OPEN_TAG,
        T_DOC_COMMENT_CLOSE_TAG,
        T_DOC_COMMENT_STAR,
        T_DOC_COMMENT_STRING,
        T_DOC_COMMENT_TAG,
        T_DOC_COMMENT_WHITESPACE,
    ];

    /** @var mixed[] */
    public static $typeHintTokenCodes = [
        T_NS_SEPARATOR,
        T_STRING,
        T_SELF,
        T_PARENT,
        T_ARRAY_HINT,
        T_CALLABLE,
    ];

    /**
     * @param File $phpcsFile
     * @param int $startPointer search starts at this token, inclusive
     * @param int|null $endPointer search ends at this token, exclusive
     * @return int|null
     */
    public static function findNextEffective(File $phpcsFile, int $startPointer, int $endPointer = null)
    {
        return self::findNextExcluding($phpcsFile, self::$ineffectiveTokenCodes, $startPointer, $endPointer);
    }

    /**
     * @param File $phpcsFile
     * @param int|int[] $types
     * @param int $startPointer search starts at this token, inclusive
     * @param int|null $endPointer search ends at this token, exclusive
     * @return int|null
     */
    public static function findNextExcluding(File $phpcsFile, $types, int $startPointer, int $endPointer = null)
    {
        $token = $phpcsFile->findNext($types, $startPointer, $endPointer, true);
        if ($token === false) {
            return null;
        }
        return $token;
    }

    /**
     * @param File $phpcsFile
     * @param int $startPointer search starts at this token, inclusive
     * @param int|null $endPointer search ends at this token, exclusive
     * @return int|null
     */
    public static function findNextAnyToken(File $phpcsFile, int $startPointer, int $endPointer = null)
    {
        return self::findNextExcluding($phpcsFile, [], $startPointer, $endPointer);
    }

    /**
     * @param File $phpcsFile
     * @param int $startPointer search starts at this token, inclusive
     * @param int|null $endPointer search ends at this token, exclusive
     * @return int|null
     */
    public static function findPreviousEffective(File $phpcsFile, int $startPointer, int $endPointer = null)
    {
        return self::findPreviousExcluding($phpcsFile, self::$ineffectiveTokenCodes, $startPointer, $endPointer);
    }

    /**
     * @param File $phpcsFile
     * @param int[]|int $types
     * @param int $startPointer search starts at this token, inclusive
     * @param int|null $endPointer search ends at this token, exclusive
     * @return int|null
     */
    public static function findPreviousExcluding(File $phpcsFile, $types, int $startPointer, int $endPointer = null)
    {
        $token = $phpcsFile->findPrevious($types, $startPointer, $endPointer, true);
        if ($token === false) {
            return null;
        }
        return $token;
    }

    /**
     * @param File $phpcsFile
     * @param int $pointer search starts at this token, inclusive
     * @return int|null
     */
    public static function findFirstTokenOnNextLine(File $phpcsFile, int $pointer)
    {
        $newLinePointer = $phpcsFile->findNext(T_WHITESPACE, $pointer, null, false, $phpcsFile->eolChar);
        if ($newLinePointer === false) {
            return null;
        }
        $tokens = $phpcsFile->getTokens();
        return isset($tokens[$newLinePointer + 1]) ? $newLinePointer + 1 : null;
    }

    public static function getContent(File $phpcsFile, int $startPointer, int $endPointer = null): string
    {
        $tokens = $phpcsFile->getTokens();
        $endPointer = $endPointer ?: self::getLastTokenPointer($phpcsFile);

        $content = '';
        for ($i = $startPointer; $i <= $endPointer; $i++) {
            $content .= $tokens[$i]['content'];
        }

        return $content;
    }

    public static function getLastTokenPointer(File $phpcsFile): int
    {
        $tokenCount = count($phpcsFile->getTokens());
        if ($tokenCount === 0) {
            throw new \SlevomatCodingStandard\Helpers\EmptyFileException($phpcsFile->getFilename());
        }
        return $tokenCount - 1;
    }
}
