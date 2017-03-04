<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\NamingConventions;

use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Sniff;

final class VariableNameLengthSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * @var int
     */
    public $minLength = 3;

    /**
     * @var string[]
     */
    public $allowedShortVariableNames = ['id'];

    /**
     * @var PHP_CodeSniffer_File
     */
    private $file;

    /**
     * @var int
     */
    private $position;

    /**
     * @return int[]
     */
    public function register(): array
    {
        return [T_VARIABLE];
    }

    /**
     * @param PHP_CodeSniffer_File $file
     * @param int                  $position
     */
    public function process(PHP_CodeSniffer_File $file, $position): void
    {
        $this->file = $file;
        $this->position = $position;

        $variableName = $this->getVariableName();
        if ($this->isAllowedShortVariableName($variableName)) {
            return;
        }

        $this->processVariableName($variableName);
    }

    private function processVariableName(string $functionName): void
    {
        $length = mb_strlen($functionName);
        if ($length >= $this->minLength) {
            return;
        }

        $message = sprintf(
            'Variable name is %d chars long. Must be at least %d.',
            $length,
            $this->minLength
        );

        $this->file->addError($message, $this->position, self::class);
    }

    private function getVariableName(): string
    {
        return trim($this->file->getTokens()[$this->position]['content'], '$');
    }

    private function isAllowedShortVariableName(string $variableName): bool
    {
        return in_array($variableName, $this->allowedShortVariableNames);
    }
}
