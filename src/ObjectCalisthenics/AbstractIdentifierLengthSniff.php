<?php

namespace ObjectCalisthenics;

use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Sniff;

/**
 * Identifier length checker, part of "Do not abbreviate" OC rule.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
abstract class AbstractIdentifierLengthSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Token string representation.
     *
     * @var string
     */
    protected $tokenString = 'variable';

    /**
     * Token type length factor, reducing the actual size of token by a factor of value.
     *
     * @var int
     */
    protected $tokenTypeLengthFactor = 1;

    /**
     * Minimum variable/method name length.
     *
     * @var int
     */
    protected $minLength = 3;

    /**
     * Maximum variable/method name length.
     *
     * @var int
     */
    protected $maxLength = 32;

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        return [T_STRING];
    }

    /**
     * {@inheritdoc}
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];

        if (!$this->isValid($phpcsFile, $stackPtr)) {
            return;
        }

        $length = strlen($token['content']) - $this->tokenTypeLengthFactor;

        if ($length > $this->maxLength) {
            $message = 'Your %s is too long (currently %d chars, must be less or equals than %d chars)';
            $error = sprintf($message, $this->tokenString, $length, $this->maxLength);

            $phpcsFile->addError($error, $stackPtr, sprintf('%sTooLong', ucfirst($this->tokenString)));
        } elseif ($length < $this->minLength) {
            $message = 'Your %s is too short (currently %d chars, must be more or equals than %d chars)';
            $error = sprintf($message, $this->tokenString, $length, $this->minLength);

            $phpcsFile->addError($error, $stackPtr, sprintf('%sTooShort', ucfirst($this->tokenString)));
        }
    }

    /**
     * Whether if token is valid to be checked over using the current sniffer.
     *
     * @return bool
     */
    abstract protected function isValid(PHP_CodeSniffer_File $phpcsFile, $stackPtr);
}
