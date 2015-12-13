<?php

namespace ObjectCalisthenics\tests\Sniffs\Files;

use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit_Framework_TestCase;

/**
 * Function length, part of "Keep your classes small" OC rule test.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
final class FunctionLengthUnitTest extends PHPUnit_Framework_TestCase
{
    public function testSniff()
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/FunctionLengthUnitTest.inc',
            'ObjectCalisthenics.Files.FunctionLength'
        );

        $this->assertSame(2, $errorCount);
    }
}
