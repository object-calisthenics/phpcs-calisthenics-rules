<?php declare(strict_types=1);

namespace ObjectCalisthenics;

use ObjectCalisthenics\Helper\Structure\StructureMetrics;
use PHP_CodeSniffer\Files\File;

/**
 * Base for class, interface, trait, function and method length checks.
 */
abstract class AbstractDataStructureLengthSniff
{
    /**
     * @var int
     */
    public $maxLength;

    /**
     * @param File $file
     * @param int $position
     */
    public function process(File $file, $position): void
    {
        $tokenType = $file->getTokens()[$position]['content'];
        $length = StructureMetrics::getStructureLengthInLines($file, $position);

        if ($length > $this->maxLength) {
            $error = sprintf(
                'Your %s is too long. Currently using %d lines. Can be up to %d lines.',
                $tokenType,
                $length,
                $this->maxLength
            );

            $file->addError($error, $position, self::class);
        }
    }
}
