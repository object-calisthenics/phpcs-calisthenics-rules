<?php

namespace ObjectCalisthenics\Tests\Sniffs\CodeAnalysis;

use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit_Framework_TestCase;

/**
 * One object operator (->) per line.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
class OneObjectOperatorPerLineUnitTest extends PHPUnit_Framework_TestCase
{
    public function testSniff()
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/OneObjectOperatorPerLineUnitTest.inc',
            'ObjectCalisthenics.CodeAnalysis.OneObjectOperatorPerLine'
        );

        $this->assertSame(2, $errorCount);
    }
}
