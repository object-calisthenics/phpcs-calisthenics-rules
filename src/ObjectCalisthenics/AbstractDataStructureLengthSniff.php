<?php

namespace ObjectCalisthenics;

use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Sniff;

/**
 * Data structure length code sniffer.
 *
 * This sniff is the base for class, interface, trait, function and method
 * length checks as part of "Keep your classes small" object calisthenics
 * rule.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
abstract class AbstractDataStructureLengthSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Maximum data structure length for warning.
     *
     * @var int
     */
    public $maxLength = 200;

    /**
     * {@inheritdoc}
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];
        $tokenType = strtolower(substr($token['type'], 2));
        $length = $this->getStructureLength($phpcsFile, $stackPtr);

        if ($length > $this->maxLength) {
            $message = 'Keep your %s small (currently using %d lines, must be less or equals than %d lines)';
            $error = sprintf($message, $tokenType, $length, $this->maxLength);
            $phpcsFile->addError($error, $stackPtr, sprintf('%sTooBig', ucfirst($tokenType)));
        }
    }

    /**
     * Retrieve the data structure LOC.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token
     *                                        in the stack passed in $tokens.
     *
     * @return int
     */
    private function getStructureLength(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];

        // Skip function without body.
        if (isset($token['scope_opener']) === false) {
            return 0;
        }

        $firstToken = $tokens[$token['scope_opener']];
        $lastToken = $tokens[$token['scope_closer']];

        return $lastToken['line'] - $firstToken['line'];
    }
}
