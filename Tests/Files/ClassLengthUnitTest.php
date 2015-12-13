<?php

/**
 * Class length, part of "Keep your classes small" OC rule test.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
class ObjectCalisthenics_Tests_Files_ClassLengthUnitTest extends ObjectCalisthenics_Tests_AbstractSniffUnitTest
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
            6 => 1,
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
