<?php

namespace ObjectCalisthenics\tests\Sniffs\NamingConventions;

use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit_Framework_TestCase;

/**
 * Variable length, part of "Do not abbreviate" OC rule test.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
final class VariableLengthUnitTest extends PHPUnit_Framework_TestCase
{
    public function testSniff()
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/VariableLengthUnitTest.inc',
            'ObjectCalisthenics.NamingConventions.VariableLength'
        );

        $this->assertSame(8, $errorCount);
    }
}
