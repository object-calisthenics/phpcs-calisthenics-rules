<?php

/**
 * Only one indentation level per method.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
class ObjectCalisthenics_Sniffs_Metrics_OneIndentationLevelSniff implements PHP_CodeSniffer_Sniff
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
    public $supportedTokenizers = array('PHP');

    /**
     * Registers the tokens that this sniff wants to listen for.
     *
     * @return integer[]
     */
    public function register()
    {
        return array(
            T_FUNCTION,
            T_CLOSURE,
        );
    }

    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * {@internal Implementation based on Generic.Metrics.NestingLevel code}
     *
     * @param \PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param integer               $stackPtr  The position of the current token
     *                                         in the stack passed in $tokens.
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $token  = $tokens[$stackPtr];

        // Ignore abstract methods.
        if (isset($token['scope_opener']) === false) {
            return;
        }

        // Detect start and end of this function definition.
        $start             = $token['scope_opener'];
        $end               = $token['scope_closer'];
        $nestingLevel      = 0;
        $ignoredScopeStack = array();

        // Find the maximum nesting level of any token in the function.
        for ($i = ($start + 1); $i < $end; $i++) {
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
            $data  = array($nestingLevel);

            $phpcsFile->addError($error, $stackPtr, 'MaxExceeded', $data);
        }
    }
}
