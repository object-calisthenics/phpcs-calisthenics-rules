<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\Files;

use ObjectCalisthenics\Helper\Structure\StructureMetrics;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

final class FunctionLengthSniff implements Sniff
{
    /**
     * @var string
     */
    private const ERROR_MESSAGE = 'Your function is too long. Currently using %d lines. Can be up to %d lines.';

    public int $maxLength = 20;

    /**
     * @return int[]
     */
    public function register(): array
    {
        return [T_FUNCTION];
    }

    /**
     * @param int $position
     */
    public function process(File $file, $position): void
    {
        $length = StructureMetrics::getStructureLengthInLines($file, $position);

        if ($length > $this->maxLength) {
            $error = sprintf(self::ERROR_MESSAGE, $length, $this->maxLength);
            $file->addError($error, $position, self::class);
        }
    }
}
