<?php declare(strict_types=1);

namespace ObjectCalisthenics;

use PHP_CodeSniffer_File;

/**
 * Identifier length checker, part of "Do not abbreviate" OC rule.
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
     * @var PHP_CodeSniffer_File
     */
    private $phpcsFile;

    /**
     * @var int
     */
    private $stackPtr;

    /**
     * @var array
     */
    private $allowedShortVariables = ['id'];

    public function register(): array
    {
        return [T_STRING];
    }

    /**
     * @param PHP_CodeSniffer_File $phpcsFile
     * @param int                  $stackPtr
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $this->phpcsFile = $phpcsFile;
        $this->stackPtr = $stackPtr;

        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];
        $content = mb_substr($token['content'], $this->tokenTypeLengthFactor);

        if (!$this->isValid($phpcsFile, $stackPtr)) {
            return;
        }

        if ($this->isShortContentAllowed($content)) {
            return;
        }

        $this->handleMinContentLength($content);
    }

    abstract protected function isValid(PHP_CodeSniffer_File $phpcsFile, int $stackPtr): bool;

    private function handleMinContentLength(string $content)
    {
        $length = mb_strlen($content);

        if ($length >= $this->minLength) {
            return;
        }

        $error = sprintf(
            'Your %s is too short (currently %d chars, must be more or equals than %d chars)',
            $this->tokenString,
            $length,
            $this->minLength
        );

        $this->phpcsFile->addError($error, $this->stackPtr, sprintf('%sTooShort', ucfirst($this->tokenString)));
    }

    private function isShortContentAllowed(string $content): bool
    {
        if ($this->register() === [T_VARIABLE] && in_array($content, $this->allowedShortVariables)) {
            return true;
        }

        return false;
    }
}
