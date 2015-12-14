<?php

namespace ObjectCalisthenics\Tests\Sniffs\Classes;

use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit_Framework_TestCase;

/**
 * @covers ObjectCalisthenics\Sniffs\Classes\PropertyVisibilitySniff
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
final class PropertyVisibilitySniffTest extends PHPUnit_Framework_TestCase
{
    public function testSniff()
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/PropertyVisibilitySniffTest.inc',
            'ObjectCalisthenics.Classes.PropertyVisibility'
        );

        $this->assertSame(2, $errorCount);
    }
}
