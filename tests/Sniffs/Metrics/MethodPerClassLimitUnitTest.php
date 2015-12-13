<?php

namespace ObjectCalisthenics\Tests\Sniffs\Metrics;

use ObjectCalisthenics\Tests\AbstractSniffUnitTest;

/**
 * Methods per class limit, part of "Keep your classes small" OC rule test.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
class MethodPerClassLimitUnitTest extends AbstractSniffUnitTest
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
            6   => 1,
            67  => 1,
            150 => 1,
        );
    }
}
