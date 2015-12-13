<?php

namespace ObjectCalisthenics\Tests\Sniffs\Metrics;

use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit_Framework_TestCase;

/**
 * One level of indentation rule unit test.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
final class OneIndentationLevelUnitTest extends PHPUnit_Framework_TestCase
{
    public function testSniff()
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/OneIndentationLevelUnitTest.inc',
            'ObjectCalisthenics.Metrics.OneIndentationLevel'
        );

        $this->assertSame(5, $errorCount);
    }
}
