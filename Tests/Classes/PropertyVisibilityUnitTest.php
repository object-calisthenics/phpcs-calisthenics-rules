<?php

/**
 * Property visibility, part of "Use getters and setters" OC rule test.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
class ObjectCalisthenics_Tests_Classes_PropertyVisibilityUnitTest extends ObjectCalisthenics_Tests_AbstractSniffUnitTest
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
            5 => 2,
            7 => 1,
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
