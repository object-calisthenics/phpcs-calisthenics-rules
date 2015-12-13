<?php

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
     * {@inheritdoc}
     */
    public $maxNestingLevel = 1;

    /**
     * Supported list of tokenizers supported by this sniff.
     *
     * @var array
     */
    public $supportedTokenizers = ['PHP'];

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        return [T_FUNCTION, T_CLOSURE];
    }

    /**
     * {@inheritdoc}
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];

        // Ignore abstract methods.
        if (isset($token['scope_opener']) === false) {
            return;
        }

        // Detect start and end of this function definition.
        $start = $token['scope_opener'];
        $end = $token['scope_closer'];
        $nestingLevel = 0;
        $ignoredScopeStack = [];

        // Find the maximum nesting level of any token in the function.
        for ($i = ($start + 1); $i < $end; ++$i) {
            $nestedToken = $tokens[$i];

            switch ($nestedToken['code']) {
                // Move index pointer in case we found a lambda function
                // (another call process will deal with its check later).
                case T_CLOSURE:
                    $i = $nestedToken['scope_closer'];

                    break;

                // Some tokens needs to be adjusted with a new stack.
                // Switch and case are considered separated scopes,
                // incrementing level twice. We need to fix this.
                case T_CASE:
                    array_push($ignoredScopeStack, $nestedToken);

                    break;

                default:
                    // Iterated through ignored scope stack to find out if
                    // anything can be popped out and adjust nesting level.
                    foreach ($ignoredScopeStack as $k => $ignoredScope) {
                        if ($ignoredScope['scope_closer'] !== $i) {
                            continue;
                        }

                        unset($ignoredScopeStack[$k]);
                    }

                    // Calculate nesting level
                    $level = $nestedToken['level'] - count($ignoredScopeStack);

                    if ($nestingLevel < $level) {
                        $nestingLevel = $level;
                    }
            }
        }

        // We subtract the nesting level of the function itself.
        $nestingLevel = ($nestingLevel - $token['level'] - 1);

        if ($nestingLevel > $this->maxNestingLevel) {
            $error = 'Only one indentation level per function/method. Found %s levels.';
            $data = [$nestingLevel];

            $phpcsFile->addError($error, $stackPtr, 'MaxExceeded', $data);
        }
    }
}
