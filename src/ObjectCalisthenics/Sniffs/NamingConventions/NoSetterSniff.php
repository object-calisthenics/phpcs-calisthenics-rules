<?php

declare(strict_types = 1);

namespace ObjectCalisthenics\Sniffs\NamingConventions;

use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Sniff;

class NoSetterSniff implements PHP_CodeSniffer_Sniff
{
    const SETTER_REGEX = '/^set[A-Z0-9]/';
    const SETTER_WARNING = 'Setters are not allowed';

    public function register()
    {
        return [T_FUNCTION];
    }

    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        if ($this->methodNameStartsWithSet($phpcsFile->getDeclarationName($stackPtr))) {
            $phpcsFile->addWarning(self::SETTER_WARNING, $stackPtr);
        }
    }

    private function methodNameStartsWithSet(string $methodName) : bool
    {
        return preg_match(self::SETTER_REGEX, $methodName) === 1;
    }
}
