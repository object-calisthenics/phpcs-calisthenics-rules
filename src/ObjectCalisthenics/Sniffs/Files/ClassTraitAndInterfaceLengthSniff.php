<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\Files;

use ObjectCalisthenics\Helper\Structure\StructureMetrics;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

final class ClassTraitAndInterfaceLengthSniff implements Sniff
{
    /**
     * @var string
     */
    private const ERROR_MESSAGE = 'Your class is too long. Currently using %d lines. Can be up to %d lines.';

    public int $maxLength = 200;

    /**
     * @return int[]
     */
    public function register(): array
    {
        return [T_CLASS, T_INTERFACE, T_TRAIT];
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
