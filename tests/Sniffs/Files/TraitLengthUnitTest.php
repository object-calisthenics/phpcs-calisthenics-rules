<?php

namespace ObjectCalisthenics\tests\Sniffs\Files;

use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit_Framework_TestCase;

/**
 * Trait length, part of "Keep your classes small" OC rule test.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
final class TraitLengthUnitTest extends PHPUnit_Framework_TestCase
{
    public function testSniff()
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/TraitLengthUnitTest.inc',
            'ObjectCalisthenics.Files.TraitLength'
        );

        $this->assertSame(1, $errorCount);
    }
}
