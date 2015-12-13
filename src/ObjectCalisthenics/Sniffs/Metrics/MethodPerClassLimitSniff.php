<?php

namespace ObjectCalisthenics\Sniffs\Metrics;

use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Sniff;

/**
 * Check for amount of methods per class, part of "Keep your classes small" OC rule.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
final class MethodPerClassLimitSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Maximum amount of methods per class.
     *
     * @var int
     */
    public $maxCount = 10;

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        return [T_CLASS, T_INTERFACE, T_TRAIT];
    }

    /**
     * {@inheritdoc}
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];
        $tokenType = strtolower(substr($token['type'], 2));
        $methods = $this->getClassMethods($phpcsFile, $stackPtr);
        $methodCount = count($methods);

        if ($methodCount > $this->maxCount) {
            $message = 'Your %s has %d methods, must be less or equals than %d methods';
            $error = sprintf($message, $tokenType, $methodCount, $this->maxCount);

            $phpcsFile->addError($error, $stackPtr, sprintf('%sTooManyMethods', ucfirst($tokenType)));
        }
    }

    /**
     * Retrieve the list of class methods' pointers.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token
     *                                        in the stack passed in $tokens.
     *
     * @return array
     */
    private function getClassMethods(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $pointer = $stackPtr;
        $methods = [];

        while (($next = $phpcsFile->findNext(T_FUNCTION, $pointer + 1)) !== false) {
            $methods[] = $next;

            $pointer = $next;
        }

        return $methods;
    }
}
