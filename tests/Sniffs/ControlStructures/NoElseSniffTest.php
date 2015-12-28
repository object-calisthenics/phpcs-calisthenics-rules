<?php

namespace ObjectCalisthenics\Tests\Sniffs\ControlStructures;

use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit_Framework_TestCase;

/**
 * @covers ObjectCalisthenics\Sniffs\ControlStructures\NoElseSniff
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
final class NoElseSniffTest extends PHPUnit_Framework_TestCase
{
    public function testSniff()
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/NoElseSniffTest.inc',
            'ObjectCalisthenics.ControlStructures.NoElse'
        );

        $this->assertSame(5, $errorCount);
    }
}
