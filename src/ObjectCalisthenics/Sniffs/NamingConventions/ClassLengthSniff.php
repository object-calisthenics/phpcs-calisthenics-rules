<?php

namespace ObjectCalisthenics\Sniffs\NamingConventions;

use ObjectCalisthenics\AbstractIdentifierLengthSniff;
use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Sniff;

/**
 * Class name length sniffer, part of "Do not abbreviate" object calisthenics rule.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
final class ClassLengthSniff extends AbstractIdentifierLengthSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * {@inheritdoc}
     */
    protected $tokenString = 'class';

    /**
     * {@inheritdoc}
     */
    protected $tokenTypeLengthFactor = 0;

    /**
     * {@inheritdoc}
     */
    protected $maxLength = 48;

    /**
     * {@inheritdoc}
     */
    protected function isValid(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        return $phpcsFile->findPrevious(T_CLASS, ($stackPtr - 1), null, false, null, true) !== false;
    }
}
