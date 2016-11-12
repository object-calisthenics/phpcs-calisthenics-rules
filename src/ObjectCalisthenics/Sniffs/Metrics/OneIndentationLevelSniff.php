<?php

declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\Metrics;

use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Sniff;

/**
 * Only one indentation level per method.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
final class OneIndentationLevelSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * @var int
     */
    private $maxNestingLevel = 1;

    /**
     * @var PHP_CodeSniffer_File
     */
    private $phpcsFile;

    /**
     * @var int
     */
    private $stackPtr;

    /**
     * @var int
     */
    private $nestingLevel;

    /**
     * @var array
     */
    private $ignoredScopeStack;

    /**
     * @var int
     */
    private $currentPtr;

    public function register() : array
    {
        return [T_FUNCTION, T_CLOSURE];
    }

    /**
     * @param PHP_CodeSniffer_File $phpcsFile
     * @param int                  $stackPtr
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $this->phpcsFile = $phpcsFile;
        $this->stackPtr = $stackPtr;
        $this->nestingLevel = 0;
        $this->ignoredScopeStack = [];

        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];

        // Ignore abstract methods.
        if (isset($token['scope_opener']) === false) {
            return;
        }

        $this->iterateTokens($token['scope_opener'], $token['scope_closer'], $tokens);

        $this->nestingLevel = $this->subtractFunctionNestingLevel($token);
        $this->handleNestingLevel($this->nestingLevel);
    }

    private function handleNestingLevel(int $nestingLevel)
    {
        if ($nestingLevel > $this->maxNestingLevel) {
            $this->phpcsFile->addError(
                'Only one indentation level per function/method. Found %s levels.',
                $this->stackPtr,
                'MaxExceeded',
                [$nestingLevel]
            );
        }
    }

    private function iterateTokens(int $start, int $end, array $tokens)
    {
        $this->currentPtr = $start + 1;

        // Find the maximum nesting level of any token in the function.
        for ($this->currentPtr = ($start + 1); $this->currentPtr < $end; ++$this->currentPtr) {
            $nestedToken = $tokens[$this->currentPtr];

            $this->handleToken($nestedToken);
        }
    }

    private function handleToken(array $nestedToken)
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

    private function subtractFunctionNestingLevel(array $token) : int
    {
        return $this->nestingLevel - $token['level'] - 1;
    }

    private function handleClosureToken(array $nestedToken)
    {
        if ($nestedToken['code'] === T_CLOSURE) {
            // Move index pointer in case we found a lambda function
            // (another call process will deal with its check later).
            $this->currentPtr = $nestedToken['scope_closer'];

            return;
        }
    }

    private function handleCaseToken(array $nestedToken)
    {
        if ($nestedToken['code'] === T_CASE) {
            // Some tokens needs to be adjusted with a new stack.
            // Switch and case are considered separated scopes,
            // incrementing level twice. We need to fix this.
            array_push($this->ignoredScopeStack, $nestedToken);

            return;
        }
    }

    private function adjustNestingLevelToIgnoredScope()
    {
        // Iterated through ignored scope stack to find out if
        // anything can be popped out and adjust nesting level.
        foreach ($this->ignoredScopeStack as $key => $ignoredScope) {
            $this->unsetScopeIfNotCurrent($key, $ignoredScope);
        }
    }

    private function unsetScopeIfNotCurrent(int $key, array $ignoredScope)
    {
        if ($ignoredScope['scope_closer'] !== $this->currentPtr) {
            return;
        }

        unset($this->ignoredScopeStack[$key]);
    }
}
