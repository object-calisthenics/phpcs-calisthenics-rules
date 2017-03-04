<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\NamingConventions;

use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Sniff;

final class FunctionNameLengthSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * @var int
     */
    private $minRequiredLength = 3;

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

        $functionNamePosition = $file->findNext(T_STRING, $position, $position + 3);
        $functionName = $file->getTokens()[$functionNamePosition]['content'];

        $this->handleMinRequiredFunctionNameLength($functionName);
    }

    private function handleMinRequiredFunctionNameLength(string $functionName): void
    {
        $length = mb_strlen($functionName);

        if ($length >= $this->minRequiredLength) {
            return;
        }

        $error = sprintf(
            'Function name is currently %d chars long. Must be at least %d.',
            $length,
            $this->minRequiredLength
        );

        $this->file->addError(
            $error,
            $this->position,
            self::class
        );
    }
}
