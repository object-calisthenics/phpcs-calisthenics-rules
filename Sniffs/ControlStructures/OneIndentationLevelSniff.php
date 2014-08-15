<?php

/**
 * Only one indentation level per method.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
class ObjectCalisthenics_Sniffs_ControlStructures_OneIndentationLevelSniff extends Generic_Sniffs_Metrics_NestingLevelSniff
{
    /**
     * {@inheritdoc}
     */
    public $nestingLevel = 1;

    /**
     * {@inheritdoc}
     */
    public $absoluteNestingLevel = 1;

    /**
     * Supported list of tokenizers supported by this sniff.
     *
     * @var array
     */
    public $supportedTokenizers = array('PHP');
}
