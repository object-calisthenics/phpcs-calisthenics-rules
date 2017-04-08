<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\Metrics;

use ObjectCalisthenics\Sniffs\Metrics\MethodPerClassLimitSniff;
use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit\Framework\TestCase;

final class MethodPerClassLimitSniffTest extends TestCase
{
    public function test(): void
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__ . '/MethodPerClassLimitSniffTest.inc',
            MethodPerClassLimitSniff::class
        );

        $this->assertSame(3, $errorCount);
    }
}
