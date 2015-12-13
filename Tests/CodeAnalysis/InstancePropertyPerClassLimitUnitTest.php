<?php

/**
 * Instance property per class limit, part of "Use first class collections" OC rule.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
class ObjectCalisthenics_Tests_CodeAnalysis_InstancePropertyPerClassLimitUnitTest extends ObjectCalisthenics_Tests_AbstractSniffUnitTest
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
            3   => 1,
            109 => 1,
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
