<?php

namespace ObjectCalisthenics\Sniffs\Files;

use ObjectCalisthenics_DataStructureLengthSniff;

/**
 * Function/CLass method length sniffer, part of "Keep your classes small" object calisthenics rule.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
class FunctionLengthSniff extends ObjectCalisthenics_DataStructureLengthSniff
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
