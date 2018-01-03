<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\ControlStructures;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

final class NoElseSniff implements Sniff
{
    /**
     * @var string
     */
    private const ERROR_MESSAGE = 'Do not use "else/elseif". Prefer early return statement instead.';

    /**
     * @return int[]
     */
    public function register(): array
    {
        return [T_ELSE, T_ELSEIF];
    }

    /**
     * @param int $position
     */
    public function process(File $file, $position): void
    {
        $file->addError(self::ERROR_MESSAGE, $position, self::class);
    }
}
