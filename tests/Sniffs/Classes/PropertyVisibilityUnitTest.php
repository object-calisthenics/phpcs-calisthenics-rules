<?php

namespace ObjectCalisthenics\Tests\Sniffs\Classes;

use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit_Framework_TestCase;

/**
 * Property visibility, part of "Use getters and setters" OC rule test.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
final class PropertyVisibilityUnitTest extends PHPUnit_Framework_TestCase
{
    public function testSniff()
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/PropertyVisibilityUnitTest.inc',
            'ObjectCalisthenics.Classes.PropertyVisibility'
        );

        $this->assertSame(3, $errorCount);
    }
}
