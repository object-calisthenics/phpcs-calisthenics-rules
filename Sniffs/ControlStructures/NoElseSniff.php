<?php

/**
 * Do not use "else" or "elseif" tokens.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
class ObjectCalisthenics_Sniffs_ControlStructures_NoElseSniff implements PHP_CodeSniffer_Sniff
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
            T_ELSE, 
            T_ELSEIF
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
        $phpcsFile->addError(
            'Do not use "else" or "elseif" tokens', 
            $stackPtr, 
            'NoElse'
        );
    } 
}
