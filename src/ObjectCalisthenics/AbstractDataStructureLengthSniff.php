<?php declare(strict_types=1);

namespace ObjectCalisthenics;

use ObjectCalisthenics\Helper\Structure\StructureMetrics;
use PHP_CodeSniffer_File;

/**
 * Data structure length code sniffer.
 *
 * This sniff is the base for class, interface, trait, function and method
 * length checks as part of "Keep your classes small" object calisthenics
 * rule.
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
        $tokens = $file->getTokens();
        $token = $tokens[$position];
        $length = StructureMetrics::getStructureLengthInLines($file, $position);

        if ($length > $this->maxLength) {
            $tokenType = strtolower(substr($token['type'], 2));
            $error = sprintf(
                'Keep your %s small (currently using %d lines, must be less or equals than %d lines)',
                $tokenType,
                $length,
                $this->maxLength
            );

            $file->addError($error, $position, sprintf('%sTooBig', ucfirst($tokenType)));
        }
    }
}
