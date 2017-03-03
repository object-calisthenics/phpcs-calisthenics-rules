<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\Metrics;

use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit\Framework\TestCase;

/**
 * @covers \ObjectCalisthenics\Sniffs\Metrics\MethodPerClassLimitSniff
 */
final class MethodPerClassLimitSniffTest extends TestCase
{
    public function test(): void
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/MethodPerClassLimitSniffTest.inc',
            'ObjectCalisthenics.Metrics.MethodPerClassLimit'
        );

        $this->assertSame(3, $errorCount);
    }
}
