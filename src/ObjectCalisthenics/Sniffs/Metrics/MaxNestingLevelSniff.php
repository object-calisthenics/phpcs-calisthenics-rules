<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\Metrics;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

final class MaxNestingLevelSniff implements Sniff
{
    /**
     * @var string
     */
    private const ERROR_MESSAGE = 'Only %d indentation level%s per function/method. Found %s levels.';

    /**
     * @var string
     */
    private const SCOPE_CLOSER = 'scope_closer';

    public int $maxNestingLevel = 2;

    private int $position;

    /**
     * @var int
     */
    private $nestingLevel;

    private int $currentPtr;

    /**
     * @var mixed[]
     */
    private array $ignoredScopeStack = [];

    private File $file;

    /**
     * @return int[]|string[]
     */
    public function register(): array
    {
        return [T_FUNCTION, T_CLOSURE];
    }

    /**
     * @param int $position
     */
    public function process(File $file, $position): void
    {
        $this->file = $file;
        $this->position = $position;
        $this->nestingLevel = 0;
        $this->ignoredScopeStack = [];

        $tokens = $file->getTokens();
        $token = $tokens[$position];

        // Ignore abstract methods.
        if (! isset($token['scope_opener'])) {
            return;
        }

        $this->iterateTokens($token['scope_opener'], $token[self::SCOPE_CLOSER], $tokens);

        $this->nestingLevel = $this->subtractFunctionNestingLevel($token);
        $this->handleNestingLevel($this->nestingLevel);
    }

    /**
     * @param mixed[] $tokens
     */
    private function iterateTokens(int $start, int $end, array $tokens): void
    {
        // Find the maximum nesting level of any token in the function.
        for ($this->currentPtr = ($start + 1); $this->currentPtr < $end; ++$this->currentPtr) {
            $nestedToken = $tokens[$this->currentPtr];

            $this->handleToken($nestedToken);
        }
    }

    /**
     * @param mixed[] $token
     */
    private function subtractFunctionNestingLevel(array $token): int
    {
        return $this->nestingLevel - $token['level'] - 1;
    }

    private function handleNestingLevel(int $nestingLevel): void
    {
        if ($nestingLevel > $this->maxNestingLevel) {
            $levelPluralization = $this->maxNestingLevel > 1 ? 's' : '';

            $error = sprintf(self::ERROR_MESSAGE, $this->maxNestingLevel, $levelPluralization, $nestingLevel);

            $this->file->addError($error, $this->position, self::class);
        }
    }

    /**
     * @param mixed[] $nestedToken
     */
    private function handleToken(array $nestedToken): void
    {
        $this->handleClosureToken($nestedToken);
        $this->handleCaseToken($nestedToken);

        $this->adjustNestingLevelToIgnoredScope();

        // Calculate nesting level
        $level = $nestedToken['level'] - count($this->ignoredScopeStack);

        if ($this->nestingLevel < $level) {
            $this->nestingLevel = $level;
        }
    }

    /**
     * @param mixed[] $nestedToken
     */
    private function handleClosureToken(array $nestedToken): void
    {
        if ($nestedToken['code'] === T_CLOSURE) {
            // Move index pointer in case we found a lambda function
            // (another call process will deal with its check later).
            $this->currentPtr = $nestedToken[self::SCOPE_CLOSER];

            return;
        }
    }

    /**
     * @param mixed[] $nestedToken
     */
    private function handleCaseToken(array $nestedToken): void
    {
        if (in_array($nestedToken['code'], [T_CASE, T_DEFAULT], true)) {
            $this->ignoredScopeStack[] = $nestedToken;

            return;
        }
    }

    private function adjustNestingLevelToIgnoredScope(): void
    {
        // Iterated through ignored scope stack to find out if
        // anything can be popped out and adjust nesting level.
        foreach ($this->ignoredScopeStack as $key => $ignoredScope) {
            $this->unsetScopeIfNotCurrent($key, $ignoredScope);
        }
    }

    /**
     * @param mixed[] $ignoredScope
     */
    private function unsetScopeIfNotCurrent(int $key, array $ignoredScope): void
    {
        if ($ignoredScope[self::SCOPE_CLOSER] !== $this->currentPtr) {
            return;
        }

        unset($this->ignoredScopeStack[$key]);
    }
}
