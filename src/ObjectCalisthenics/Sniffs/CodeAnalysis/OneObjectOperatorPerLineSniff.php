<?php

declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\CodeAnalysis;

use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Sniff;

/**
 * Only one object operator per line.
 */
final class OneObjectOperatorPerLineSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * @var PHP_CodeSniffer_File
     */
    private $phpcsFile;

    /**
     * @var int
     */
    private $stackPtr;

    /**
     * @var array
     */
    private $callerTokens;

    /**
     * @var string
     */
    private $variableName;

    /**
     * Comma separated list of variables that will start the fluent interface mode.
     *
     * @var string
     */
    public $variablesHoldingAFluentInterface = '$queryBuilder';

    /**
     * Comma separated list of methods that will start the fluent interface mode.
     *
     * @var string
     */
    public $methodsStartingAFluentInterface = 'createQueryBuilder';

    /**
     * Comma separated list of methods that will end the fluent interface mode.
     *
     * @var string
     */
    public $methodsEndingAFluentInterface = 'execute,getQuery';

    public function register() : array
    {
        return [T_VARIABLE];
    }

    /**
     * @param PHP_CodeSniffer_File $phpcsFile
     * @param int                  $stackPtr
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $this->phpcsFile = $phpcsFile;
        $this->stackPtr = $stackPtr;
        $this->callerTokens = [];

        $tokens = $phpcsFile->getTokens();
        $this->variableName = $tokens[$stackPtr]['content'];
        $pointer = $this->ignoreWhitespace($tokens, $stackPtr + 1);

        $token = $tokens[$stackPtr];
        $isOwnCall = ($token['content'] === '$this');

        try {
            $this->handleObjectOperators($tokens, $pointer, $isOwnCall);
        } catch (\Exception $exception) {
            return;
        }
    }

    private function ignoreWhitespace(array $tokens, int $start) : int
    {
        $pointer = $start;

        while ($tokens[$pointer]['code'] === T_WHITESPACE) {
            ++$pointer;
        }

        return $pointer;
    }

    private function handleTwoObjectOperators(bool $isOwnCall)
    {
        if ($this->callerTokens && !$isOwnCall && !$this->isInFluentInterfaceMode()) {
            $this->phpcsFile->addError('Only one object operator per line.', $this->stackPtr);

            throw new \Exception();
        }
    }

    private function handleExcludedFluentInterfaces(array $tmpToken, string $tmpTokenType)
    {
        if (!$this->callerTokens) {
            return;
        }

        $memberTokenCount = count($this->callerTokens);
        $memberToken = end($this->callerTokens);
        $memberTokenType = $memberToken['type'];

        if (
            ($memberTokenType === 'property' && $tmpTokenType === 'property') ||
            ($memberTokenType === 'method' && $tmpTokenType === 'property') ||
            ($memberTokenType === 'method' && $tmpTokenType === 'method'
                && $memberTokenCount > 1 && $memberToken['token']['content'] !== $tmpToken['content'] && !$this->isInFluentInterfaceMode())
        ) {
            $this->phpcsFile->addError('Only one object operator per line.', $this->stackPtr);

            throw new \Exception();
        }
    }

    private function isInFluentInterfaceMode(): bool
    {
        $lastEndPoint = $this->computeLastCallOfAnyFrom(explode(',', $this->methodsEndingAFluentInterface));
        $lastStartPoint = $this->computeLastCallOfAnyFrom(explode(',', $this->methodsStartingAFluentInterface));

        if (in_array($this->variableName, explode(',', $this->variablesHoldingAFluentInterface), true)) {
            $lastStartPoint = max($lastStartPoint, -1);
        }

        return $lastStartPoint > -2
            && $lastStartPoint > $lastEndPoint;
    }

    /**
     * @param array $methods
     *
     * @return int The last position of the method calls within the callerTokens
     *             or -2 if none of the methods has been called
     */
    private function computeLastCallOfAnyFrom(array $methods): int
    {
        $calls = array_filter($this->callerTokens, function (array $token) use ($methods) {
            return in_array($token['token']['content'], $methods);
        });
        if (count($calls) > 0) {
            return array_search(end($calls), $this->callerTokens);
        }

        return -2;
    }

    private function handleObjectOperators(array $tokens, int $pointer, bool $isOwnCall)
    {
        while ($tokens[$pointer]['code'] === T_OBJECT_OPERATOR) {
            $tmpToken = $tokens[++$pointer];
            $pointer = $this->ignoreWhitespace($tokens, $pointer + 1);
            $tmpTokenType = $this->getTokenType($tokens[$pointer]);

            // Look for second object operator token on same statement
            $this->handleTwoObjectOperators($isOwnCall);
            $this->handleExcludedFluentInterfaces($tmpToken, $tmpTokenType);

            $this->callerTokens[] = [
                'token' => $tmpToken,
                'type' => $tmpTokenType,
            ];

            $pointer = $this->movePointerToNextObject($tokens, $pointer);
        }
    }

    /**
     * @param array $token
     *
     * @return string
     */
    private function getTokenType($token)
    {
        if ($token['code'] === T_OPEN_PARENTHESIS) {
            return 'method';
        }

        return 'property';
    }

    /**
     * @param array $tokens
     * @param int   $pointer
     *
     * @return string
     */
    private function movePointerToNextObject(array $tokens, $pointer)
    {
        $token = $tokens[$pointer];

        // Ignore "(" ... ")" in a method call by moving pointer after close parenthesis token
        if ($token['code'] === T_OPEN_PARENTHESIS) {
            $pointer = $token['parenthesis_closer'] + 1;
        }

        return $this->ignoreWhitespace($tokens, $pointer);
    }
}
