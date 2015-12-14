<?php

namespace ObjectCalisthenics;

use PHP_CodeSniffer_File;

/**
 * Identifier length checker, part of "Do not abbreviate" OC rule.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
abstract class AbstractIdentifierLengthSniff
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
    public function register()
    {
        return [T_STRING];
    }

    /**
     * @param PHP_CodeSniffer_File $phpcsFile
     * @param int $stackPtr
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $this->phpcsFile = $phpcsFile;
        $this->stackPtr = $stackPtr;

        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];

        if (!$this->isValid($phpcsFile, $stackPtr)) {
            return;
        }

        $length = strlen($token['content']) - $this->tokenTypeLengthFactor;

        $this->handleMaxLength($length);
        $this->handleMinLength($length);
    }

    /**
     * Whether if token is valid to be checked over using the current sniffer.
     *
     * @return bool
     */
    abstract protected function isValid(PHP_CodeSniffer_File $phpcsFile, $stackPtr);

    /**
     * @param int $length
     */
    private function handleMaxLength($length)
    {
        if ($length > $this->maxLength) {
            $error = sprintf(
                'Your %s is too long (currently %d chars, must be less or equals than %d chars)',
                $this->tokenString,
                $length,
                $this->maxLength
            );

            $this->phpcsFile->addError($error, $this->stackPtr, sprintf('%sTooLong', ucfirst($this->tokenString)));
        }
    }

    /**
     * @param int $length
     */
    private function handleMinLength($length)
    {
        if ($length < $this->minLength) {
            $error = sprintf(
                'Your %s is too short (currently %d chars, must be more or equals than %d chars)',
                $this->tokenString,
                $length,
                $this->minLength
            );

            $this->phpcsFile->addError($error, $this->stackPtr, sprintf('%sTooShort', ucfirst($this->tokenString)));
        }
    }
}
