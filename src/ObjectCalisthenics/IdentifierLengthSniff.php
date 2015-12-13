<?php

namespace ObjectCalisthenics;

use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Sniff;

/**
 * Identifier length checker, part of "Do not abbreviate" OC rule.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
abstract class IdentifierLengthSniff implements PHP_CodeSniffer_Sniff
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
    public $minLength = 3;

    /**
     * Absolute minimum variable/method name length.
     *
     * @var int
     */
    public $absoluteMinLength = 3;

    /**
     * Maximum variable/method name length.
     *
     * @var int
     */
    public $maxLength = 32;

    /**
     * Absolute maximum variable/method name length.
     *
     * @var int
     */
    public $absoluteMaxLength = 32;

    /**
     * Supported list of tokenizers supported by this sniff.
     *
     * @var array
     */
    public $supportedTokenizers = ['PHP'];

    /**
     * Registers the tokens that this sniff wants to listen for.
     *
     * @return int[]
     */
    abstract public function register();

    /**
     * Whether if token is valid to be checked over using the current sniffer.
     *
     * @return bool
     */
    abstract public function isValid(PHP_CodeSniffer_File $phpcsFile, $stackPtr);

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

        switch (true) {
            case $length > $this->absoluteMaxLength:
                $message = 'Your %s is too long (currently %d chars, must be less or equals than %d chars)';
                $error = sprintf($message, $this->tokenString, $length, $this->absoluteMaxLength);

                $phpcsFile->addError($error, $stackPtr, sprintf('%sTooLong', ucfirst($this->tokenString)));

                break;

            case $length > $this->maxLength:
                $message = 'Your %s is too long, consider refactoring (currently %d chars, should be less or equals than %d chars)';
                $warning = sprintf($message, $this->tokenString, $length, $this->maxLength);

                $phpcsFile->addWarning($warning, $stackPtr, sprintf('%sTooLong', ucfirst($this->tokenString)));

                break;

            case $length < $this->absoluteMinLength:
                $message = 'Your %s is too short (currently %d chars, must be more or equals than %d chars)';
                $error = sprintf($message, $this->tokenString, $length, $this->absoluteMinLength);

                $phpcsFile->addError($error, $stackPtr, sprintf('%sTooShort', ucfirst($this->tokenString)));

                break;

            case $length < $this->minLength:
                $message = 'Your %s is too short, consider refactoring (currently %d chars, should be more or equals than %d chars)';
                $warning = sprintf($message, $this->tokenString, $length, $this->minLength);

                $phpcsFile->addWarning($warning, $stackPtr, sprintf('%sTooShort', ucfirst($this->tokenString)));

                break;
        }
    }
}
