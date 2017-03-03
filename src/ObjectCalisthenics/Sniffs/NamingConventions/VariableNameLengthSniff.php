<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\NamingConventions;

use ObjectCalisthenics\AbstractIdentifierLengthSniff;
use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Sniff;

final class VariableNameLengthSniff extends AbstractIdentifierLengthSniff implements PHP_CodeSniffer_Sniff
{
    public function register(): array
    {
        return [T_VARIABLE];
    }

    protected function isValid(PHP_CodeSniffer_File $file, int $position): bool
    {
        return true;
    }
}
