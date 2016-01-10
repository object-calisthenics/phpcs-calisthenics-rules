<?php

namespace ObjectCalisthenics\Tests\Sniffs\CodeAnalysis;

use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit_Framework_TestCase;

/**
 * @covers ObjectCalisthenics\Sniffs\CodeAnalysis\ArrayPropertyPerClassLimitSniff
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
final class ArrayPropertyPerClassLimitSniffTest extends PHPUnit_Framework_TestCase
{
    public function testSniff()
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/ArrayPropertyPerClassLimitSniffTest.inc',
            'ObjectCalisthenics.CodeAnalysis.ArrayPropertyPerClassLimit'
        );

        $this->assertSame(2, $errorCount);
    }
}
