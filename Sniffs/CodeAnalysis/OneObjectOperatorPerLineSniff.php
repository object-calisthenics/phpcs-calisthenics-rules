<?php

namespace ObjectCalisthenics\Sniffs\CodeAnalysis;

use PHP_CodeSniffer_Sniff;

/**
 * Only one object operator per line.
 *
 * However, this rule applies explicetly to Java, where there is no need to use
 * this when calling class members. Based on PHP's nature, it is enforced that
 * you use $this, this rule then contains some exceptions.
 * You can have more than one object operator, if your code contains one of the
 * following sitations:
 *
 * - $this->property->method();
 * - $this->property->method()->method()->...(); // Fluent interface
 * - $this->method()->anotherMethod();
 * - $this->method()->method()->method()->...(); // Fluent interface
 *
 * You cannot have more than one object operator if you have:
 *
 * - $object->method();
 * - $object->property;
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
class OneObjectOperatorPerLineSniff implements PHP_CodeSniffer_Sniff
{
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
            T_VARIABLE,
        );
    }

    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param \PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param integer               $stackPtr  The position of the current token
     *                                         in the stack passed in $tokens.
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens       = $phpcsFile->getTokens();
        $token        = $tokens[$stackPtr];
        $isOwnCall    = ($token['content'] === '$this');
        $pointer      = $this->ignoreWhitespace($tokens, $stackPtr + 1);
        $callerTokens = array();

        while ($tokens[$pointer]['code'] === T_OBJECT_OPERATOR) {
            $tmpToken     = $tokens[++$pointer];
            $pointer      = $this->ignoreWhitespace($tokens, $pointer + 1);
            $tmpTokenType = ($tokens[$pointer]['code'] === T_OPEN_PARENTHESIS)
                ? 'method'
                : 'property';

            // Look for second object operator token on same statement
            if ($callerTokens) {
                $memberTokenCount = count($callerTokens);
                $memberToken      = end($callerTokens);
                $memberTokenType  = $memberToken['type'];

                // Handle $object situation (you cannot have 2 object operators)
                if ( ! $isOwnCall) {
                    $phpcsFile->addError('Only one object operator per line.', $stackPtr);

                    return;
                }

                // Fluent interface over method chaining on $this:
                // Should work:
                // - $this -> Property -> Method
                // - $this -> Method -> AnotherMethod
                // - $this -> Method -> Method
                // - $this -> Method -> AnotherMethod -> AnotherMethod
                // Should fail:
                // - $this -> Property -> Property
                // - $this -> Method -> Property
                // - $this -> Method -> AnotherMethod -> YetAnotherMethod
                if (
                    ($memberTokenType === 'property' && $tmpTokenType === 'property') ||
                    ($memberTokenType === 'method' && $tmpTokenType === 'property') ||
                    ($memberTokenType === 'method' && $tmpTokenType === 'method' && $memberTokenCount > 1 && $memberToken['token']['content'] !== $tmpToken['content'])
                ) {
                    $phpcsFile->addError('Only one object operator per line.', $stackPtr);

                    return;
                }
            }

            // Ignore "(" ... ")" in a method call by moving pointer after close parenthesis token
            if ($tokens[$pointer]['code'] === T_OPEN_PARENTHESIS) {
                $pointer = $tokens[$pointer]['parenthesis_closer'] + 1;
            }

            $pointer = $this->ignoreWhitespace($tokens, $pointer);

            array_push(
                $callerTokens,
                array(
                    'token' => $tmpToken,
                    'type'  => $tmpTokenType,
                )
            );
        }
    }

    private function ignoreWhitespace(array $tokens, $start)
    {
        $pointer = $start;

        while ($tokens[$pointer]['code'] === T_WHITESPACE) {
            $pointer++;
        }

        return $pointer;
    }
}
