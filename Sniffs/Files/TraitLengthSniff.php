<?php

namespace ObjectCalisthenics\Sniffs\Files;

use ObjectCalisthenics_DataStructureLengthSniff;

/**
 * Trait length sniffer, part of "Keep your classes small" object calisthenics rule.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
class TraitLengthSniff extends ObjectCalisthenics_DataStructureLengthSniff
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
