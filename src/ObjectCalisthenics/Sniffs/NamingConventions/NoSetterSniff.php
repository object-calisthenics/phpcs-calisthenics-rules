<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\NamingConventions;

use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Sniff;

final class NoSetterSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * @var string
     */
    private const SETTER_REGEX = '/^set[A-Z0-9]/';

    /**
     * @var string
     */
    private const SETTER_WARNING = 'Setters are not allowed';

    public function register(): array
    {
        return [T_FUNCTION];
    }

    /**
     * @param PHP_CodeSniffer_File $file
     * @param int                  $position
     */
    public function process(PHP_CodeSniffer_File $file, $position): void
    {
        if ($this->methodNameStartsWithSet($file->getDeclarationName($position))) {
            $file->addError(self::SETTER_WARNING, $position);
        }
    }

    private function methodNameStartsWithSet(string $methodName): bool
    {
        return $methodName !== 'setUp'
            && preg_match(self::SETTER_REGEX, $methodName) === 1;
    }
}
