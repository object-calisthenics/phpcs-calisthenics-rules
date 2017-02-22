<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\CodeAnalysis;

use ObjectCalisthenics\Sniffs\CodeAnalysis\OneObjectOperatorPerLineSniff;
use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit\Framework\TestCase;

final class OneObjectOperatorPerLineSniffTest extends TestCase
{
    public function test(): void
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/OneObjectOperatorPerLineSniffTest.inc',
            OneObjectOperatorPerLineSniff::class
        );

        $this->assertSame(2, $errorCount);
    }

    public function testFluentInterfaces()
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/OneObjectOperatorPerLineSniffTestFluentInterface.inc',
            OneObjectOperatorPerLineSniff::class
        );

        $this->assertSame(1, $errorCount);
    }
}
