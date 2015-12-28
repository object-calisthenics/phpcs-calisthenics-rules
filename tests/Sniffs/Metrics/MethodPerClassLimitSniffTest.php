<?php

namespace ObjectCalisthenics\Tests\Sniffs\Metrics;

use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit_Framework_TestCase;

/**
 * @covers ObjectCalisthenics\Sniffs\Metrics\MethodPerClassLimitSniff
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
final class MethodPerClassLimitSniffTest extends PHPUnit_Framework_TestCase
{
    public function testSniff()
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/MethodPerClassLimitSniffTest.inc',
            'ObjectCalisthenics.Metrics.MethodPerClassLimit'
        );

        $this->assertSame(3, $errorCount);
    }
}
