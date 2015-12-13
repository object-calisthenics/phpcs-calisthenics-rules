<?php

namespace ObjectCalisthenics\Sniffs\Files;

use ObjectCalisthenics\DataStructureLengthSniff;

/**
 * Function/CLass method length sniffer, part of "Keep your classes small" object calisthenics rule.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
final class FunctionLengthSniff extends DataStructureLengthSniff
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
        return [T_FUNCTION];
    }
}