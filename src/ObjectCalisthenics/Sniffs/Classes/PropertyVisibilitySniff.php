<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\Classes;

use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Sniff;
use PHP_CodeSniffer_Standards_AbstractVariableSniff;
use PHP_CodeSniffer_Tokens;

/**
 * Check for property visibility, part of "Use getter/setter methods" OC rule.
 *
 * {@internal Barbara Liskov feels sick every time she looks at this class code.}
 */
final class PropertyVisibilitySniff extends PHP_CodeSniffer_Standards_AbstractVariableSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * @var array
     */
    private $tokens;

    /**
     * @var PHP_CodeSniffer_File
     */
    private $file;

    /**
     * @var int
     */
    private $position;

    /**
     * @param PHP_CodeSniffer_File $file
     * @param int                  $position
     */
    protected function processMemberVar(PHP_CodeSniffer_File $file, $position): void
    {
        $this->file = $file;
        $this->position = $position;
        $this->tokens = $file->getTokens();

        $this->handleMultiPropertyDeclaration();

        $modifier = $file->findPrevious(PHP_CodeSniffer_Tokens::$scopeModifiers, ($position - 1));

        // Check for no visibility declaration

        $this->handleVisibilityDeclaration($modifier);
        $this->handlePublicProperty($modifier);
    }

    /**
     * @param PHP_CodeSniffer_File $file
     * @param int                  $position
     */
    protected function processVariable(PHP_CodeSniffer_File $file, $position): void
    {
        // We don't care about normal variables.
    }

    /**
     * @param PHP_CodeSniffer_File $file
     * @param int                  $position
     */
    protected function processVariableInString(PHP_CodeSniffer_File $file, $position): void
    {
        // We don't care about normal variables.
    }

    private function handleMultiPropertyDeclaration(): void
    {
        if (($nextPtr = $this->file->findNext(T_VARIABLE, ($this->position + 1), null, false, null, true)) !== false) {
            $this->file->addError('There must not be more than one property declared per statement', $this->position, 'MultiPropertyDecl');
        }
    }

    /**
     * @param int|bool $modifier
     */
    private function handlePublicProperty($modifier): void
    {
        if ($this->tokens[$modifier]['code'] === T_PUBLIC) {
            $this->file->addError('Use getters and setters for properties. Public visibility is discouraged.', $this->position, 'PublicProperty');
        }
    }

    /**
     * @param int|bool $modifier
     */
    private function handleVisibilityDeclaration($modifier): void
    {
        if (($modifier === false) || ($this->tokens[$modifier]['line'] !== $this->tokens[$this->position]['line'])) {
            $this->file->addError(
                sprintf('Visibility must be declared on property "%s"', $this->tokens[$this->position]['content']),
                $this->position,
                'ScopeMissing'
            );
        }
    }
}
