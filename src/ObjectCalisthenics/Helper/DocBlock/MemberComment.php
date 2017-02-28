<?php declare(strict_types=1);

namespace ObjectCalisthenics\Helper\DocBlock;

use PHP_CodeSniffer_File;

final class MemberComment
{
    public static function getMemberComment(PHP_CodeSniffer_File $phpcsFile, int $stackPtr): string
    {
        $docCommentPosition = $phpcsFile->findPrevious(T_DOC_COMMENT_STRING, $stackPtr, $stackPtr - 10);
        if (!$docCommentPosition) {
            return '';
        }

        $docCommentToken = $phpcsFile->getTokens()[$docCommentPosition];
        $docComment = $docCommentToken['content'];
        if (false !== strpos($docComment, 'inheritdoc')) {
            return '';
        }

        return $docComment;
    }
}
