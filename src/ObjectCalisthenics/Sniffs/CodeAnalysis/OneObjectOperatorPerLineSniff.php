<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\CodeAnalysis;

use ObjectCalisthenics\Helper\FluentInterfaceDetector;
use ObjectCalisthenics\ValueObject\TokenKey;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

final class OneObjectOperatorPerLineSniff implements Sniff
{
    /**
     * @var string
     */
    private const ERROR_MESSAGE = 'Only one object operator per line.';

    /**
     * @var string
     */
    private const METHOD = 'method';

    /**
     * @var string
     */
    private const PROPERTY = 'property';

    /**
     * @var string[]
     */
    public array $variablesHoldingAFluentInterface = ['$queryBuilder', '$containerBuilder'];

    /**
     * @var string[]
     */
    public array $methodsStartingAFluentInterface = ['createQueryBuilder'];

    /**
     * @var string[]
     */
    public array $methodsEndingAFluentInterface = ['execute', 'getQuery'];

    private int $position;

    private string $variableName;

    /**
     * @var mixed[]
     */
    private array $callerTokens = [];

    /**
     * @var mixed[]
     */
    private array $tokens = [];

    private File $file;

    /**
     * @return int[]
     */
    public function register(): array
    {
        return [T_VARIABLE];
    }

    /**
     * @param int $position
     */
    public function process(File $file, $position): void
    {
        $this->file = $file;
        $this->position = $position;
        $this->tokens = $file->getTokens();

        $this->callerTokens = [];

        $pointer = $this->ignoreWhitespace($position + 1);
        $this->variableName = $this->tokens[$this->position][TokenKey::CONTENT];

        $token = $this->tokens[$position];
        $isOwnCall = ($token[TokenKey::CONTENT] === '$this');

        $this->handleObjectOperators($pointer, $isOwnCall);
    }

    private function ignoreWhitespace(int $start): int
    {
        $pointer = $start;

        while ($this->tokens[$pointer][TokenKey::CODE] === T_WHITESPACE) {
            ++$pointer;
        }

        return $pointer;
    }

    private function handleObjectOperators(int $pointer, bool $isOwnCall): void
    {
        while ($this->tokens[$pointer][TokenKey::CODE] === T_OBJECT_OPERATOR) {
            $tmpToken = $this->tokens[++$pointer];
            $pointer = $this->ignoreWhitespace($pointer + 1);
            $tmpTokenType = $this->getTokenType($this->tokens[$pointer]);

            // Look for second object operator token on same statement
            $this->handleTwoObjectOperators($isOwnCall);
            $this->handleExcludedFluentInterfaces($tmpToken, $tmpTokenType, $isOwnCall);

            $this->callerTokens[] = [
                TokenKey::TOKEN => $tmpToken,
                TokenKey::TYPE => $tmpTokenType,
            ];

            $pointer = $this->movePointerToNextObject($pointer);
        }
    }

    /**
     * @param mixed[] $token
     */
    private function getTokenType(array $token): string
    {
        if ($token[TokenKey::CODE] === T_OPEN_PARENTHESIS) {
            return self::METHOD;
        }

        return self::PROPERTY;
    }

    private function handleTwoObjectOperators(bool $isOwnCall): void
    {
        if ($this->callerTokens && ! $isOwnCall && ! $this->isInFluentInterfaceMode()) {
            $this->file->addError(self::ERROR_MESSAGE, $this->position, self::class);
        }
    }

    /**
     * @param mixed[] $tmpToken
     */
    private function handleExcludedFluentInterfaces(array $tmpToken, string $tmpTokenType, bool $isOwnCall): void
    {
        if ((count($this->callerTokens) - (int) $isOwnCall) === 0) {
            return;
        }

        $memberTokenCount = count($this->callerTokens);
        $memberToken = end($this->callerTokens);
        if ($memberToken === false) {
            return;
        }

        if (($memberToken[TokenKey::TYPE] === self::PROPERTY && $tmpTokenType === self::PROPERTY)
            || ($memberToken[TokenKey::TYPE] === self::METHOD && $tmpTokenType === self::PROPERTY)
            || ($memberToken[TokenKey::TYPE] === self::METHOD && $tmpTokenType === self::METHOD
            && $memberTokenCount > 1 && $tmpToken[TokenKey::CONTENT] !== $memberToken[TokenKey::TOKEN][TokenKey::CONTENT]
            && ! $this->isInFluentInterfaceMode())
        ) {
            $this->file->addError(self::ERROR_MESSAGE, $this->position, self::class);
        }
    }

    private function movePointerToNextObject(int $pointer): int
    {
        $token = $this->tokens[$pointer];

        // Ignore "(" ... ")" in a method call by moving pointer after close parenthesis token
        if ($token[TokenKey::CODE] === T_OPEN_PARENTHESIS) {
            $pointer = $token['parenthesis_closer'] + 1;
        }

        return $this->ignoreWhitespace($pointer);
    }

    private function isInFluentInterfaceMode(): bool
    {
        $fluentInterfaceDetector = new FluentInterfaceDetector();

        return $fluentInterfaceDetector->isInFluentInterfaceMode(
            $this->methodsEndingAFluentInterface,
            $this->methodsStartingAFluentInterface,
            $this->variableName,
            $this->variablesHoldingAFluentInterface,
            $this->callerTokens
        );
    }
}
