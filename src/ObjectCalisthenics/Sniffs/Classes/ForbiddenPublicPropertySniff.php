<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\Classes;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\AbstractVariableSniff;
use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Util\Tokens;

final class ForbiddenPublicPropertySniff extends AbstractVariableSniff implements Sniff
{
    /**
     * @var string
     */
    private const ERROR_MESSAGE = 'Do not use public properties. Use method access instead.';

    /**
     * @var array
     */
    private $tokens;

    /**
     * @var File
     */
    private $file;

    /**
     * @var int
     */
    private $position;

    /**
     * @param File $file
     * @param int  $position
     */
    protected function processMemberVar(File $file, $position): void
    {
        $this->file = $file;
        $this->position = $position;
        $this->tokens = $file->getTokens();

        $modifier = $file->findPrevious(Tokens::$scopeModifiers, ($position - 1));

        $this->handlePublicProperty($modifier);
    }

    /**
     * @param File $file
     * @param int  $position
     */
    protected function processVariable(File $file, $position): void
    {
        // We don't care about normal variables.
    }

    /**
     * @param File $file
     * @param int  $position
     */
    protected function processVariableInString(File $file, $position): void
    {
        // We don't care about normal variables.
    }

    /**
     * @param int|bool $modifier
     */
    private function handlePublicProperty($modifier): void
    {
        if ($this->tokens[$modifier]['code'] === T_PUBLIC) {
            $this->file->addError(self::ERROR_MESSAGE, $this->position, self::class);
        }
    }
}
