<?php

namespace ObjectCalisthenics\Sniffs\Files;

use ObjectCalisthenics\AbstractDataStructureLengthSniff;

/**
 * Function/class method length sniffer,
 * part of "Keep your classes small" object calisthenics rule.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
final class FunctionLengthSniff extends AbstractDataStructureLengthSniff
{
    /**
     * {@inheritdoc}
     */
    protected $maxLength = 20;

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        return [T_FUNCTION];
    }
}
