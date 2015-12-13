<?php

namespace ObjectCalisthenics\Tests\NamingConventions;

use ObjectCalisthenics\Tests\AbstractSniffUnitTest;

/**
 * Variable length, part of "Do not abbreviate" OC rule test.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
class VariableLengthUnitTest extends AbstractSniffUnitTest
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
            7  => 1,
            9  => 1,
            11 => 1,
            18 => 1,
            20 => 3,
            21 => 1,
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
