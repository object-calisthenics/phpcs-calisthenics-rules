<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\NamingConventions;

use Nette\Utils\Strings;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use SlevomatCodingStandard\Helpers\ClassHelper;

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
    private const SETTER_REGEX = '#^set[A-Z0-9]#';

    /**
     * @var string[]
     */
    public array $allowedClasses = [];

    /**
     * @return int[]
     */
    public function register(): array
    {
        return [T_FUNCTION];
    }

    /**
     * @param int $position
     */
    public function process(File $file, $position): void
    {
        $methodName = $file->getDeclarationName($position);
        if ($methodName === null) {
            return;
        }

        $className = $this->getClassName($file);
        if ($this->shouldSkip($methodName, $className)) {
            return;
        }

        if (! (bool) Strings::match($methodName, self::SETTER_REGEX)) {
            return;
        }

        $file->addError(self::ERROR_MESSAGE, $position, self::class);
    }

    private function getClassName(File $file): string
    {
        $classTokenPosition = $file->findNext(T_CLASS, 0);

        // anonymous class
        if (! is_int($classTokenPosition)) {
            return 'anonymous';
        }

        $className = ClassHelper::getFullyQualifiedName($file, $classTokenPosition);

        return ltrim($className, '\\');
    }

    private function shouldSkip(string $methodName, string $className): bool
    {
        // not really a setter, but usually test "setup" method
        if ($methodName === 'setUp') {
            return true;
        }

        foreach ($this->allowedClasses as $allowedClass) {
            if (fnmatch($allowedClass, $className, FNM_NOESCAPE)) {
                return true;
            }
        }

        return false;
    }
}
