<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\NamingConventions;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

final class NoSetterSniff implements Sniff
{
    /**
     * @var string
     */
    private const ERROR_MESSAGE = 'Setters are not allowed. Use constructor injection and'
        . ' behavior naming instead, e.g. changeName() instead of setName().';

    /**
     * @var string
     */
    private const SETTER_REGEX = '/^set[A-Z0-9]/';

    /**
     * @return int[]
     */
    public function register(): array
    {
        return [T_FUNCTION];
    }

    /**
     * @param File $file
     * @param int  $position
     */
    public function process(File $file, $position): void
    {
        $declarationName = $file->getDeclarationName($position);
        if ($declarationName === null) {
            return;
        }

        if ($this->methodNameStartsWithSet($declarationName)) {
            $file->addError(self::ERROR_MESSAGE, $position, self::class);
        }
    }

    private function methodNameStartsWithSet(string $methodName): bool
    {
        return $methodName !== 'setUp'
            && preg_match(self::SETTER_REGEX, $methodName) === 1;
    }
}
