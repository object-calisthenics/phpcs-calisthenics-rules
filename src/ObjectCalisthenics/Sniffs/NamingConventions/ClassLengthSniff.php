<?php

namespace ObjectCalisthenics\Sniffs\NamingConventions;

use ObjectCalisthenics_IdentifierLengthSniff;

/**
 * Class length sniffer, part of "Do not abbreviate" object calisthenics rule.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
class ClassLengthSniff extends ObjectCalisthenics_IdentifierLengthSniff
{
    /**
     * {@inheritdoc}
     */
    public $tokenString = 'class';

    /**
     * {@inheritdoc}
     */
    public $tokenTypeLengthFactor = 0;

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
        return array(T_STRING);
    }

    /**
     * {@inheritdoc}
     */
    public function isValid(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        return ($phpcsFile->findPrevious(T_CLASS, ($stackPtr - 1), null, false, null, true) !== false);
    }
}
