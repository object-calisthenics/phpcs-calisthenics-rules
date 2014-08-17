<?php

/**
 * Trait length sniffer, part of "Keep your classes small" object calisthenics rule.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
class ObjectCalisthenics_Sniffs_Files_TraitLengthSniff extends ObjectCalisthenics_Sniffs_Files_DataStructureLengthSniff
{
    /**
     * {@inheritdoc}
     */
    public $maxLength = 200;

    /**
     * {@inheritdoc}
     */
    public $absoluteMaxLength = 200; 

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        return array(T_TRAIT);
    }    
}
