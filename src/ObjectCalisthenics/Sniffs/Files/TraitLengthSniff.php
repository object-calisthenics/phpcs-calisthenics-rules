<?php

namespace ObjectCalisthenics\Sniffs\Files;

use ObjectCalisthenics\AbstractDataStructureLengthSniff;

/**
 * Trait length sniffer, part of "Keep your classes small" object calisthenics rule.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
final class TraitLengthSniff extends AbstractDataStructureLengthSniff
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
        return [T_TRAIT];
    }
}
