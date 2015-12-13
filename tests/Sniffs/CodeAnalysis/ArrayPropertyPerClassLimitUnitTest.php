<?php

namespace ObjectCalisthenics\Tests\Sniffs\CodeAnalysis;

use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit_Framework_TestCase;

/**
 * Array property per class limit, part of "Use first class collections" OC rule.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
class ArrayPropertyPerClassLimitUnitTest extends PHPUnit_Framework_TestCase
{
    public function testSniff()
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/ArrayPropertyPerClassLimitUnitTest.inc',
            'ObjectCalisthenics.CodeAnalysis.ArrayPropertyPerClassLimit'
        );

        $this->assertCount(2, $errorCount);
    }
}
