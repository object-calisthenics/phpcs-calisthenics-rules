<?php

namespace ObjectCalisthenics\tests\Sniffs\Metrics;

use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit_Framework_TestCase;

/**
 * Methods per class limit, part of "Keep your classes small" OC rule test.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
final class MethodPerClassLimitUnitTest extends PHPUnit_Framework_TestCase
{
    public function testSniff()
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/MethodPerClassLimitUnitTest.inc',
            'ObjectCalisthenics.Metrics.MethodPerClassLimit'
        );

        $this->assertSame(3, $errorCount);
    }
}
