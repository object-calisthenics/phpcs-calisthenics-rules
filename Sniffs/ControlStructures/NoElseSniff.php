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
     * Retrieve the list of tokens this sniff wants to subscribe for processing.
     *
     * @return array
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
     * @param \PHP_CodeSniffer_File $phpcsFile
     * @param int                   $stackPtr
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
