<?php

declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\CodeAnalysis;

use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit\Framework\TestCase;

/**
 * @covers \ObjectCalisthenics\Sniffs\CodeAnalysis\OneObjectOperatorPerLineSniff
 */
final class OneObjectOperatorPerLineSniffTest extends TestCase
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

    public function testFluentInterfaces()
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/OneObjectOperatorPerLineSniffTestFluentInterface.inc',
            'ObjectCalisthenics.CodeAnalysis.OneObjectOperatorPerLine'
        );

        $this->assertSame(1, $errorCount);
    }
}
