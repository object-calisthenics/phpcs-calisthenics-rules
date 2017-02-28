<?php declare(strict_types=1);

namespace ObjectCalisthenics;

use ObjectCalisthenics\Helper\Structure\StructureMetrics;
use PHP_CodeSniffer_File;

/**
 * Data structure length code sniffer.
 *
 * This sniff is thegs base for class, interface, trait, function and method
 * length checks as part of "Keep your classes small" object calisthenics
 * rule.
 */
abstract class AbstractDataStructureLengthSniff
{
    /**
     * Maximum data structure length.
     *
     * @var int
     */
    protected $maxLength = 200;

    /**
     * @param PHP_CodeSniffer_File $phpcsFile
     * @param int                  $stackPtr
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];
        $length = StructureMetrics::getStructureLengthInLines($phpcsFile, $stackPtr);

        if ($length > $this->maxLength) {
            $tokenType = strtolower(substr($token['type'], 2));
            $error = sprintf(
                'Keep your %s small (currently using %d lines, must be less or equals than %d lines)',
                $tokenType,
                $length,
                $this->maxLength
            );

            $phpcsFile->addError($error, $stackPtr, sprintf('%sTooBig', ucfirst($tokenType)));
        }
    }
}
