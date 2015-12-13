<?php

namespace ObjectCalisthenics\Tests\Sniffs\CodeAnalysis;

use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit_Framework_TestCase;

/**
 * @covers ObjectCalisthenics\Sniffs\CodeAnalysis\InstancePropertyPerClassLimitSniff
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
final class InstancePropertyPerClassLimitSniffTest extends PHPUnit_Framework_TestCase
{
    public function testSniff()
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/InstancePropertyPerClassLimitSniffTest.inc',
            'ObjectCalisthenics.CodeAnalysis.InstancePropertyPerClassLimit'
        );

        $this->assertSame(2, $errorCount);
    }
}
