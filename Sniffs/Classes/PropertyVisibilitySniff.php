<?php

/**
 * Check for proterty visibility, part of "Use getter/setter methods" OC rule.
 *
 * {@internal Barbara Liskov feels sick every time she looks at this class code.}
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
class ObjectCalisthenics_Sniffs_Classes_PropertyVisibilitySniff extends PHP_CodeSniffer_Standards_AbstractVariableSniff
{
    /**
     * Supported list of tokenizers supported by this sniff.
     *
     * @var array
     */
    public $supportedTokenizers = array('PHP');

    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param \PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param integer               $stackPtr  The position of the current token
     *                                         in the stack passed in $tokens.
     */
    protected function processMemberVar(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        // Break if we find a VAR declaration
        if (($previousPtr = $phpcsFile->findPrevious(T_VAR, ($stackPtr - 1), null, false, null, true)) !== false) {
            $phpcsFile->addError('Burn in hell PHP 4 demon!', $previousPtr, 'BadPHP4Code');
        }

        // Avoid multiple variables declaration
        if (($nextPtr = $phpcsFile->findNext(T_VARIABLE, ($stackPtr + 1), null, false, null, true)) !== false) {
            $phpcsFile->addError('There must not be more than one property declared per statement', $nextPtr, 'MultiPropertyDecl');
        }

        $modifier = $phpcsFile->findPrevious(PHP_CodeSniffer_Tokens::$scopeModifiers, ($stackPtr - 1));

        // Check for no visibility declaration
        if (($modifier === false) || ($tokens[$modifier]['line'] !== $tokens[$stackPtr]['line'])) {
            $phpcsFile->addError(sprintf('Visibility must be declared on property "%s"', $tokens[$stackPtr]['content']), $stackPtr, 'ScopeMissing');
        }

        // If we find a public property, notify about the usage of getter/setters
        if ($tokens[$modifier]['code'] === T_PUBLIC) {
            $phpcsFile->addError('Use getters and setters for properties. Public visibility is discouraged.', $stackPtr, 'PublicProperty');
        }
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
}
