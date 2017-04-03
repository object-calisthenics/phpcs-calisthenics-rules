<?php

declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\Metrics;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * MaxNestingLevelSniff
 *
 * @uses Sniff
 */
final class MaxNestingLevelSniff implements Sniff
{
    /**
     * @var int
     */
    public $maxNestingLevel = 2;

    /**
     * @var File
     */
    private $file;

    /**
     * @var int
     */
    private $position;

    /**
     * @var int
     */
    private $nestingLevel;

    /**
     * @var array
     */
    private $ignoredScopeStack = [];

    /**
     * @var int
     */
    private $currentPtr;

    /**
     * @return array
     */
    public function register(): array
    {
        return [T_FUNCTION, T_CLOSURE];
    }

    /**
     * @param File $file
     * @param int  $position
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
        if (isset($token['scope_opener']) === false) {
            return;
        }

        $this->iterateTokens($token['scope_opener'], $token['scope_closer'], $tokens);

        $this->nestingLevel = $this->subtractFunctionNestingLevel($token);
        $this->handleNestingLevel($this->nestingLevel);
    }

    /**
     * @param int $nestingLevel
     * @return void
     */
    private function handleNestingLevel(int $nestingLevel): void
    {
        if ($nestingLevel > $this->maxNestingLevel) {
            $levelPluralization = $this->maxNestingLevel > 1 ? 's' : '';
            $this->file->addError(
                'Only %d indentation level%s per function/method. Found %s levels.',
                $this->position,
                'MaxExceeded',
                [$this->maxNestingLevel, $levelPluralization, $nestingLevel]
            );
        }
    }

    /**
     * @param int $start
     * @param int $end
     * @param array $tokens
     * @return void
     */
    private function iterateTokens(int $start, int $end, array $tokens): void
    {
        $this->currentPtr = $start + 1;

        // Find the maximum nesting level of any token in the function.
        for ($this->currentPtr = ($start + 1); $this->currentPtr < $end; ++$this->currentPtr) {
            $nestedToken = $tokens[$this->currentPtr];

            $this->handleToken($nestedToken);
        }
    }

    /**
     * @param array $nestedToken
     * @return void
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
     * @param array $token
     * @return int
     */
    private function subtractFunctionNestingLevel(array $token): int
    {
        return $this->nestingLevel - $token['level'] - 1;
    }

    /**
     * @param array $nestedToken
     * @return void
     */
    private function handleClosureToken(array $nestedToken)
    {
        if ($nestedToken['code'] === T_CLOSURE) {
            // Move index pointer in case we found a lambda function
            // (another call process will deal with its check later).
            $this->currentPtr = $nestedToken['scope_closer'];

            return;
        }
    }

    /**
     * @param array $nestedToken
     * @return void
     */
    private function handleCaseToken(array $nestedToken): void
    {
        if (in_array($nestedToken['code'], [T_CASE, T_DEFAULT])) {
            array_push($this->ignoredScopeStack, $nestedToken);

            return;
        }
    }

    /**
     * @return void
     */
    private function adjustNestingLevelToIgnoredScope(): void
    {
        // Iterated through ignored scope stack to find out if
        // anything can be popped out and adjust nesting level.
        foreach ($this->ignoredScopeStack as $key => $ignoredScope) {
            $this->unsetScopeIfNotCurrent($key, $ignoredScope);
        }
    }

    /**
     * @param int $key
     * @param array $ignoredScope
     * @return void
     */
    private function unsetScopeIfNotCurrent(int $key, array $ignoredScope): void
    {
        if ($ignoredScope['scope_closer'] !== $this->currentPtr) {
            return;
        }

        unset($this->ignoredScopeStack[$key]);
    }
}
