<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\NamingConventions;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

final class NoSetterSniff implements Sniff
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
     * @param File $file
     * @param int                  $position
     */
    public function process(File $file, $position): void
    {
        if ($this->methodNameStartsWithSet($file->getDeclarationName($position))) {
            $file->addError(self::SETTER_WARNING, $position, self::class);
        }
    }

    private function methodNameStartsWithSet(string $methodName): bool
    {
        return $methodName !== 'setUp'
            && preg_match(self::SETTER_REGEX, $methodName) === 1;
    }
}
