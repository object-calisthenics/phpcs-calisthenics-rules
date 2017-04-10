<?php declare(strict_types=1);

namespace ObjectCalisthenics\Helper\DocBlock;

use PHP_CodeSniffer\Files\File;

final class MemberComment
{
    public static function getMemberComment(File $file, int $position): string
    {
        $docCommentPosition = $file->findPrevious(T_DOC_COMMENT_STRING, $position, $position - 10);
        if (! $docCommentPosition) {
            return '';
        }

        $docCommentToken = $file->getTokens()[$docCommentPosition];
        $docComment = $docCommentToken['content'];
        if (strpos($docComment, 'inheritdoc') !== false) {
            return '';
        }

        return $docComment;
    }
}
