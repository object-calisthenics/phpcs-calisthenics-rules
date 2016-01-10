<?php

namespace ObjectCalisthenics\Tests\Sniffs\CodeAnalysis;

use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit_Framework_TestCase;

/**
 * @covers ObjectCalisthenics\Sniffs\CodeAnalysis\OneObjectOperatorPerLineSniff
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
final class OneObjectOperatorPerLineSniffTest extends PHPUnit_Framework_TestCase
{
    public function testSniff()
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/OneObjectOperatorPerLineSniffTest.inc',
            'ObjectCalisthenics.CodeAnalysis.OneObjectOperatorPerLine'
        );

        $this->assertSame(2, $errorCount);
    }
}
