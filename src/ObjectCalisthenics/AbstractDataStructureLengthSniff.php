<?php declare(strict_types=1);

namespace ObjectCalisthenics;

use ObjectCalisthenics\Helper\Structure\StructureMetrics;
use PHP_CodeSniffer_File;

/**
 * Base for class, interface, trait, function and method length checks.
 */
abstract class AbstractDataStructureLengthSniff
{
    /**
     * @var int
     */
    public $maxLength = 200;

    /**
     * @param PHP_CodeSniffer_File $file
     * @param int                  $position
     */
    public function process(PHP_CodeSniffer_File $file, $position): void
    {
        $tokenType = $file->getTokens()[$position]['content'];
        $length = StructureMetrics::getStructureLengthInLines($file, $position);

        if ($length > $this->maxLength) {
            $error = sprintf(
                'Keep your %s small (currently using %d lines, must be less or equals than %d lines)',
                $tokenType,
                $length,
                $this->maxLength
            );

            $file->addError($error, $position, self::class);
        }
    }
}
