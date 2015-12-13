<?php

namespace ObjectCalisthenics\Sniffs\NamingConventions;

use ObjectCalisthenics\IdentifierLengthSniff;
use PHP_CodeSniffer_File;

/**
 * Variable length sniffer, part of "Do not abbreviate" object calisthenics rule.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
class VariableLengthSniff extends IdentifierLengthSniff
{
    /**
     * {@inheritdoc}
     */
    public $tokenString = 'variable';

    /**
     * {@inheritdoc}
     */
    public $tokenTypeLengthFactor = 1;

    /**
     * {@inheritdoc}
     */
    public $minLength = 3;

    /**
     * {@inheritdoc}
     */
    public $absoluteMinLength = 3;

    /**
     * {@inheritdoc}
     */
    public $maxLength = 32;

    /**
     * {@inheritdoc}
     */
    public $absoluteMaxLength = 64;

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        return array(T_VARIABLE);
    }

    /**
     * {@inheritdoc}
     */
    public function isValid(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        return true;
    }
}
