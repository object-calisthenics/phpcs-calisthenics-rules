<?php

namespace ObjectCalisthenics\Sniffs\Files;

use ObjectCalisthenics\AbstractDataStructureLengthSniff;
use PHP_CodeSniffer_Sniff;

/**
 * Function/class method length sniffer,
 * part of "Keep your classes small" object calisthenics rule.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
final class FunctionLengthSniff extends AbstractDataStructureLengthSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * {@inheritdoc}
     */
    protected $maxLength = 20;

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        return [T_FUNCTION];
    }
}
