<?php

namespace ObjectCalisthenics\Sniffs\Files;

use ObjectCalisthenics\AbstractDataStructureLengthSniff;
use PHP_CodeSniffer_Sniff;

/**
 * Class, interface and trait length sniffer,
 * part of "Keep your classes small" object calisthenics rule.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
final class ClassElementLengthSniff extends AbstractDataStructureLengthSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * {@inheritdoc}
     */
    public function register()
    {
        return [T_CLASS, T_INTERFACE, T_TRAIT];
    }
}
