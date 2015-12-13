<?php

namespace ObjectCalisthenics\Tests\Sniffs\ControlStructures;

use ObjectCalisthenics\Tests\AbstractSniffUnitTest;

/**
 * No "else" rule unit test
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
class ObjectCalisthenics_Tests_ControlStructures_NoElseUnitTest extends AbstractSniffUnitTest
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
            4  => 1,
            8  => 1,
            12 => 1,
            13 => 1,
            14 => 1,
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
