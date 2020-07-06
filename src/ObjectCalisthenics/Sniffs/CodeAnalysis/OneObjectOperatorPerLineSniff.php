<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\CodeAnalysis;

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
    private const CONTENT = 'content';

    /**
     * @var string
     */
    private const CODE = 'code';

    /**
     * @var string
     */
    private const TOKEN = 'token';

    /**
     * @var string
     */
    private const TYPE = 'type';

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
    public $variablesHoldingAFluentInterface = ['$queryBuilder', '$containerBuilder'];

    /**
     * @var string[]
     */
    public $methodsStartingAFluentInterface = ['createQueryBuilder'];

    /**
     * @var string[]
     */
    public $methodsEndingAFluentInterface = ['execute', 'getQuery'];

    /**
     * @var int
     */
    private $position;

    /**
     * @var string
     */
    private $variableName;

    /**
     * @var mixed[]
     */
    private $callerTokens = [];

    /**
     * @var mixed[]
     */
    private $tokens = [];

    /**
     * @var File
     */
    private $file;

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
        $this->variableName = $this->tokens[$this->position][self::CONTENT];

        $token = $this->tokens[$position];
        $isOwnCall = ($token[self::CONTENT] === '$this');

        $this->handleObjectOperators($pointer, $isOwnCall);
    }

    private function ignoreWhitespace(int $start): int
    {
        $pointer = $start;

        while ($this->tokens[$pointer][self::CODE] === T_WHITESPACE) {
            ++$pointer;
        }

        return $pointer;
    }

    private function handleObjectOperators(int $pointer, bool $isOwnCall): void
    {
        while ($this->tokens[$pointer][self::CODE] === T_OBJECT_OPERATOR) {
            $tmpToken = $this->tokens[++$pointer];
            $pointer = $this->ignoreWhitespace($pointer + 1);
            $tmpTokenType = $this->getTokenType($this->tokens[$pointer]);

            // Look for second object operator token on same statement
            $this->handleTwoObjectOperators($isOwnCall);
            $this->handleExcludedFluentInterfaces($tmpToken, $tmpTokenType, $isOwnCall);

            $this->callerTokens[] = [
                self::TOKEN => $tmpToken,
                self::TYPE => $tmpTokenType,
            ];

            $pointer = $this->movePointerToNextObject($pointer);
        }
    }

    /**
     * @param mixed[] $token
     */
    private function getTokenType(array $token): string
    {
        if ($token[self::CODE] === T_OPEN_PARENTHESIS) {
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

        if (($memberToken[self::TYPE] === self::PROPERTY && $tmpTokenType === self::PROPERTY)
            || ($memberToken[self::TYPE] === self::METHOD && $tmpTokenType === self::PROPERTY)
            || ($memberToken[self::TYPE] === self::METHOD && $tmpTokenType === self::METHOD
            && $memberTokenCount > 1 && $tmpToken[self::CONTENT] !== $memberToken[self::TOKEN][self::CONTENT]
            && ! $this->isInFluentInterfaceMode())
        ) {
            $this->file->addError(self::ERROR_MESSAGE, $this->position, self::class);
        }
    }

    private function movePointerToNextObject(int $pointer): int
    {
        $token = $this->tokens[$pointer];

        // Ignore "(" ... ")" in a method call by moving pointer after close parenthesis token
        if ($token[self::CODE] === T_OPEN_PARENTHESIS) {
            $pointer = $token['parenthesis_closer'] + 1;
        }

        return $this->ignoreWhitespace($pointer);
    }

    private function isInFluentInterfaceMode(): bool
    {
        $lastEndPoint = $this->computeLastCallOfAnyFrom($this->methodsEndingAFluentInterface);
        $lastStartPoint = $this->computeLastCallOfAnyFrom($this->methodsStartingAFluentInterface);

        if (in_array($this->variableName, $this->variablesHoldingAFluentInterface, true)) {
            $lastStartPoint = max($lastStartPoint, -1);
        }

        return $lastStartPoint > -2
            && $lastStartPoint > $lastEndPoint;
    }

    /**
     * @param string[] $methods
     *
     * @return int The last position of the method calls within the callerTokens
     *             or -2 if none of the methods has been called
     */
    private function computeLastCallOfAnyFrom(array $methods): int
    {
        $calls = array_filter($this->callerTokens, function (array $token) use ($methods): bool {
            return in_array($token[self::TOKEN][self::CONTENT], $methods, true);
        });
        if (count($calls) > 0) {
            return (int) array_search(end($calls), $this->callerTokens, true);
        }

        return -2;
    }
}
