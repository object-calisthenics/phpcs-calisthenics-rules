<?php

namespace ObjectCalisthenics\Sniffs\NamingConventions;

use ObjectCalisthenics\AbstractIdentifierLengthSniff;
use PHP_CodeSniffer_File;

/**
 * {@inheritdoc}
 */
final class ClassElementLengthSniff extends AbstractIdentifierLengthSniff
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
        return [T_STRING];
    }

    /**
     * {@inheritdoc}
     */
    public function isValid(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        return $phpcsFile->findPrevious(T_CLASS, ($stackPtr - 1), null, false, null, true) !== false;
    }
}
