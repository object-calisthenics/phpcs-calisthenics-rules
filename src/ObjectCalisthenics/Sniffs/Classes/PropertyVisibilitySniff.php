<?php

namespace ObjectCalisthenics\Sniffs\Classes;

use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Sniff;
use PHP_CodeSniffer_Standards_AbstractVariableSniff;
use PHP_CodeSniffer_Tokens;

/**
 * Check for proterty visibility, part of "Use getter/setter methods" OC rule.
 *
 * {@internal Barbara Liskov feels sick every time she looks at this class code.}
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
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
    private $phpcsFile;

    /**
     * @var int
     */
    private $stackPtr;

    /**
     * {@inheritdoc}
     */
    protected function processMemberVar(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $this->phpcsFile = $phpcsFile;
        $this->stackPtr = $stackPtr;
        $this->tokens = $phpcsFile->getTokens();

        $this->handleMultiPropertyDeclaration();

        $modifier = $phpcsFile->findPrevious(PHP_CodeSniffer_Tokens::$scopeModifiers, ($stackPtr - 1));

        // Check for no visibility declaration

        $this->handleVisibilityDeclaration($modifier);
        $this->handlePublicProperty($modifier);
    }

    /**
     * {@inheritdoc}
     */
    protected function processVariable(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        // We don't care about normal variables.
    }

    /**
     * {@inheritdoc}
     */
    protected function processVariableInString(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        // We don't care about normal variables.
    }

    private function handleMultiPropertyDeclaration()
    {
        if (($nextPtr = $this->phpcsFile->findNext(T_VARIABLE, ($this->stackPtr + 1), null, false, null, true)) !== false) {
            $this->phpcsFile->addError('There must not be more than one property declared per statement', $this->stackPtr, 'MultiPropertyDecl');
        }
    }

    /**
     * @param string $modifier
     */
    private function handlePublicProperty($modifier)
    {
        if ($this->tokens[$modifier]['code'] === T_PUBLIC) {
            $this->phpcsFile->addError('Use getters and setters for properties. Public visibility is discouraged.', $this->stackPtr, 'PublicProperty');
        }
    }

    /**
     * @param string $modifier
     */
    private function handleVisibilityDeclaration($modifier)
    {
        if (($modifier === false) || ($this->tokens[$modifier]['line'] !== $this->tokens[$this->stackPtr]['line'])) {
            $this->phpcsFile->addError(
                sprintf('Visibility must be declared on property "%s"', $this->tokens[$this->stackPtr]['content']),
                $this->stackPtr,
                'ScopeMissing'
            );
        }
    }
}
