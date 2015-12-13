<?php

namespace ObjectCalisthenics\Sniffs\Files;

use ObjectCalisthenics\AbstractDataStructureLengthSniff;

/**
 * Class length sniffer, part of "Keep your classes small" object calisthenics rule.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
final class ClassLengthSniff extends AbstractDataStructureLengthSniff
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
        return [T_CLASS];
    }
}
