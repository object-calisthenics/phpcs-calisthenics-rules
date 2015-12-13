<?php

namespace ObjectCalisthenics\tests\Sniffs\ControlStructures;

use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit_Framework_TestCase;

/**
 * No "else" rule unit test.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
final class NoElseUnitTest extends PHPUnit_Framework_TestCase
{
    public function testSniff()
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/NoElseUnitTest.inc',
            'ObjectCalisthenics.ControlStructures.NoElse'
        );

        $this->assertSame(5, $errorCount);
    }
}
