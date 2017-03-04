<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\NamingConventions;

use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Sniff;

final class FunctionNameLengthSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * @var int
     */
    public $minLength = 3;

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
        return [T_FUNCTION];
    }

    /**
     * @param PHP_CodeSniffer_File $file
     * @param int                  $position
     */
    public function process(PHP_CodeSniffer_File $file, $position): void
    {
        $this->file = $file;
        $this->position = $position;

        $this->processFunctionName($this->getFunctionName());
    }

    private function processFunctionName(string $functionName): void
    {
        $length = mb_strlen($functionName);
        if ($length >= $this->minLength) {
            return;
        }

        $message = sprintf(
            'Function name is %d chars long. Must be at least %d.',
            $length,
            $this->minLength
        );

        $this->file->addError($message, $this->position, self::class);
    }

    private function getFunctionName(): string
    {
        $functionNamePosition = $this->file->findNext(T_STRING, $this->position, $this->position + 3);

        return $this->file->getTokens()[$functionNamePosition]['content'];
    }
}
