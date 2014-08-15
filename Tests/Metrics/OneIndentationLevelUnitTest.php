<?php

/**
 * One level of indentation rule unit test
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
class ObjectCalisthenics_Tests_Metrics_OneIndentationLevelUnitTest extends AbstractSniffUnitTest
{
    /**
     * Returns the lines where errors should occur.
     *
     * The key of the array should represent the line number and the value
     * should represent the number of errors that should occur on that line.
     *
     * @return array
     */
    public function getErrorList()
    {
        return array(
            5  => 1,
            23 => 1,
            41 => 1,
            60 => 1,
            90 => 1,
        );
    }

    /**
     * Returns the lines where warnings should occur.
     *
     * The key of the array should represent the line number and the value
     * should represent the number of errors that should occur on that line.
     *
     * @return array
     */
    public function getWarningList()
    {
        return array();
    }
}
