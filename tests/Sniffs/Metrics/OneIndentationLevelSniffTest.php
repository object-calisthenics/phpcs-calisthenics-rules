<?php

namespace ObjectCalisthenics\Tests\Sniffs\Metrics;

use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit_Framework_TestCase;

/**
 * @covers ObjectCalisthenics\Sniffs\Metrics\OneIndentationLevelSniff
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
final class OneIndentationLevelSniffTest extends PHPUnit_Framework_TestCase
{
    public function testSniff()
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/OneIndentationLevelSniffTest.inc',
            'ObjectCalisthenics.Metrics.OneIndentationLevel'
        );

        $this->assertSame(5, $errorCount);
    }
}
