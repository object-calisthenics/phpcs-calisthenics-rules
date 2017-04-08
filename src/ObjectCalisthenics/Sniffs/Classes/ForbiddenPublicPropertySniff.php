<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\Classes;

use Nette\Utils\Strings;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\AbstractVariableSniff;
use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Util\Tokens;

final class ForbiddenPublicPropertySniff extends AbstractVariableSniff implements Sniff
{
    /**
     * @var string[]
     */
    public $filesToBeSkipped = [];

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
        if ($this->isFileSkipped($file->getFilename())) {
            return;
        }

        $this->file = $file;
        $this->position = $position;
        $this->tokens = $file->getTokens();

        $this->handleMultiPropertyDeclaration();

        $modifier = $file->findPrevious(Tokens::$scopeModifiers, ($position - 1));

        // Check for no visibility declaration

        $this->handleVisibilityDeclaration($modifier);
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

    private function handleMultiPropertyDeclaration(): void
    {
        if (($nextPtr = $this->file->findNext(T_VARIABLE, ($this->position + 1), null, false, null, true)) !== false) {
            $this->file->addError(
                'There must not be more than one property declared per statement',
                $this->position,
                ''
            );
        }
    }

    /**
     * @param int|bool $modifier
     */
    private function handlePublicProperty($modifier): void
    {
        if ($this->tokens[$modifier]['code'] === T_PUBLIC) {
            $this->file->addError(
                'Use getters and setters for properties. Public visibility is discouraged.',
                $this->position,
                ''
            );
        }
    }

    /**
     * @param int|bool $modifier
     */
    private function handleVisibilityDeclaration($modifier): void
    {
        if ($modifier === false || $this->tokens[$modifier]['line'] !== $this->tokens[$this->position]['line']) {
            $this->file->addError(
                sprintf('Visibility must be declared on property "%s"', $this->tokens[$this->position]['content']),
                $this->position,
                ''
            );
        }
    }

    private function isFileSkipped(string $filename): bool
    {
        foreach ($this->filesToBeSkipped as $fileToBeSkipped) {
            if (Strings::endsWith($filename, $fileToBeSkipped)) {
                return true;
            }
        }

        return false;
    }
}
