<?php

namespace ObjectCalisthenics\Sniffs\Files;

use ObjectCalisthenics\DataStructureLengthSniff;

/**
 * Trait length sniffer, part of "Keep your classes small" object calisthenics rule.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
class TraitLengthSniff extends DataStructureLengthSniff
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
