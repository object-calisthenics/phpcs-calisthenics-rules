<?php declare(strict_types=1);

namespace ObjectCalisthenics\Helper\DocBlock;

use PHP_CodeSniffer_File;

final class MemberComment
{
    public static function getMemberComment(PHP_CodeSniffer_File $file, int $position): string
    {
        $docCommentPosition = $file->findPrevious(T_DOC_COMMENT_STRING, $position, $position - 10);
        if (!$docCommentPosition) {
            return '';
        }

        $docCommentToken = $file->getTokens()[$docCommentPosition];
        $docComment = $docCommentToken['content'];
        if (false !== strpos($docComment, 'inheritdoc')) {
            return '';
        }

        return $docComment;
    }
}
