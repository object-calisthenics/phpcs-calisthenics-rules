<?php

/**
 * Function/CLass method length sniffer, part of "Keep your classes small" object calisthenics rule.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
class ObjectCalisthenics_Sniffs_Files_FunctionLengthSniff extends ObjectCalisthenics_Sniffs_Files_DataStructureLengthSniff
{
    /**
     * {@inheritdoc}
     */
    public $maxLength = 20;

    /**
     * {@inheritdoc}
     */
    public $absoluteMaxLength = 20; 

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        return array(T_FUNCTION);
    }    
}
