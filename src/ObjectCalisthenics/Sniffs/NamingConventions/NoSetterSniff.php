<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\NamingConventions;

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
     * @var string
     */
    public const NAMESPACE_SEPARATOR = '\\';

    /**
     * @var string[]
     */
    public $allowedClasses = [];

    /** @var (int|string)[] */
    public static $nameTokenCodes = [
        T_NS_SEPARATOR,
        T_STRING,
    ];

    /** @var (int|string)[] */
    public static $ineffectiveTokenCodes = [
        T_WHITESPACE,
        T_COMMENT,
        T_DOC_COMMENT,
        T_DOC_COMMENT_OPEN_TAG,
        T_DOC_COMMENT_CLOSE_TAG,
        T_DOC_COMMENT_STAR,
        T_DOC_COMMENT_STRING,
        T_DOC_COMMENT_TAG,
        T_DOC_COMMENT_WHITESPACE,
        T_PHPCS_DISABLE,
        T_PHPCS_ENABLE,
        T_PHPCS_IGNORE,
        T_PHPCS_IGNORE_FILE,
        T_PHPCS_SET,
    ];

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

        if (! (bool) preg_match(self::SETTER_REGEX, $methodName)) {
            return;
        }

        $file->addError(self::ERROR_MESSAGE, $position, self::class);
    }

    private function getClassName(File $file)
    {
        $classTokenPosition = $file->findNext(T_CLASS, 0);

        // anonymous class
        if (! is_integer($classTokenPosition)) {
            return 'anonymous';
        }

        $className = $this->getFullyQualifiedName($file, $classTokenPosition);

        return ltrim($className, '\\');
    }

    private function getFullyQualifiedName(File $phpcsFile, int $classPointer)
    {
        $className = $this->getName($phpcsFile, $classPointer);

        $tokens = $phpcsFile->getTokens();
        if ($tokens[$classPointer]['code'] === T_ANON_CLASS) {
            return $className;
        }

        $name = sprintf('%s%s', self::NAMESPACE_SEPARATOR, $className);
        $namespace = $this->findCurrentNamespaceName($phpcsFile, $classPointer);
        return $namespace !== null ? sprintf('%s%s%s', self::NAMESPACE_SEPARATOR, $namespace, $name) : $name;
    }

    private function getName(File $phpcsFile, int $classPointer): string
    {
        $tokens = $phpcsFile->getTokens();

        if ($tokens[$classPointer]['code'] === T_ANON_CLASS) {
            return 'class@anonymous';
        }

        return $tokens[$this->findNext($phpcsFile, T_STRING, $classPointer + 1, $tokens[$classPointer]['scope_opener'])]['content'];
    }

    private function findNext(File $phpcsFile, $types, int $startPointer, ?int $endPointer = null): ?int
    {
        /** @var int|false $token */
        $token = $phpcsFile->findNext($types, $startPointer, $endPointer, false);
        return $token === false ? null : $token;
    }

    private function findCurrentNamespaceName(File $phpcsFile, int $anyPointer) {
        $namespacePointer = $this->findPrevious($phpcsFile, T_NAMESPACE, $anyPointer);
        if ($namespacePointer === null) {
            return null;
        }

        /** @var int $namespaceNameStartPointer */
        $namespaceNameStartPointer = $this->findNextEffective($phpcsFile, $namespacePointer + 1);
        $namespaceNameEndPointer = $this->findNextExcluding($phpcsFile, self::$nameTokenCodes, $namespaceNameStartPointer + 1) - 1;

        return $this->getContent($phpcsFile, $namespaceNameStartPointer, $namespaceNameEndPointer);
    }

    private function findPrevious(File $phpcsFile, $types, int $startPointer, ?int $endPointer = null): ?int
    {
        /** @var int|false $token */
        $token = $phpcsFile->findPrevious($types, $startPointer, $endPointer, false);
        return $token === false ? null : $token;
    }

    private function findNextEffective(File $phpcsFile, int $startPointer, ?int $endPointer = null)
    {
        return self::findNextExcluding($phpcsFile, self::$ineffectiveTokenCodes, $startPointer, $endPointer);
    }

    private function findNextExcluding(File $phpcsFile, $types, int $startPointer, ?int $endPointer = null) {
        /** @var int|false $token */
        $token = $phpcsFile->findNext($types, $startPointer, $endPointer, true);
        return $token === false ? null : $token;
    }

    private function getContent(File $phpcsFile, int $startPointer, ?int $endPointer = null): string
    {
        $tokens = $phpcsFile->getTokens();
        $endPointer = $endPointer ?? $this->getLastTokenPointer($phpcsFile);

        $content = '';
        for ($i = $startPointer; $i <= $endPointer; $i++) {
            $content .= $tokens[$i]['content'];
        }

        return $content;
    }

    private function getLastTokenPointer(File $phpcsFile): int
    {
        $tokenCount = count($phpcsFile->getTokens());
        if ($tokenCount === 0) {
            throw new Exception($phpcsFile->getFilename());
        }
        return $tokenCount - 1;
    }

    private function shouldSkip(string $methodName, string $className)
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
