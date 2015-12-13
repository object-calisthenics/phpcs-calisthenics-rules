<?php

namespace ObjectCalisthenics\Sniffs\NamingConventions;

use ObjectCalisthenics\AbstractIdentifierLengthSniff;
use PHP_CodeSniffer_File;

/**
 * Variable name length sniffer, part of "Do not abbreviate" object calisthenics rule.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
final class VariableLengthSniff extends AbstractIdentifierLengthSniff
{
    /**
     * {@inheritdoc}
     */
    public function register()
    {
        return [T_VARIABLE];
    }

    /**
     * {@inheritdoc}
     */
    protected function isValid(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        return true;
    }
}
