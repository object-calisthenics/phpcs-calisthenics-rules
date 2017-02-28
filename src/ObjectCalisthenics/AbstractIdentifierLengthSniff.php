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
    private $file;

    /**
     * @var int
     */
    private $position;

    /**
     * @var array
     */
    private $allowedShortVariables = ['id'];

    public function register(): array
    {
        return [T_STRING];
    }

    /**
     * @param PHP_CodeSniffer_File $file
     * @param int                  $position
     */
    public function process(PHP_CodeSniffer_File $file, $position): void
    {
        $this->file = $file;
        $this->position = $position;

        $tokens = $file->getTokens();
        $token = $tokens[$position];
        $content = mb_substr($token['content'], $this->tokenTypeLengthFactor);

        if (!$this->isValid($file, $position)) {
            return;
        }

        if ($this->isShortContentAllowed($content)) {
            return;
        }

        $this->handleMinContentLength($content);
    }

    abstract protected function isValid(PHP_CodeSniffer_File $file, int $position): bool;

    private function handleMinContentLength(string $content): void
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

        $this->file->addError($error, $this->position, sprintf('%sTooShort', ucfirst($this->tokenString)));
    }

    private function isShortContentAllowed(string $content): bool
    {
        return $this->register() === [T_VARIABLE] && in_array($content, $this->allowedShortVariables);
    }
}
