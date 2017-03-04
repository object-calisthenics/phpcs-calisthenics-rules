<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\Metrics;

use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit\Framework\TestCase;

/**
 * @covers \ObjectCalisthenics\Sniffs\Metrics\MaxNestingLevelSniff
 */
final class MaxNestingLevelSniffTest extends TestCase
{
    public function test(): void
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/MaxNestingLevelSniffTest.inc',
            'ObjectCalisthenics.Metrics.MaxNestingLevel'
        );

        $this->assertSame(1, $errorCount);
    }
}
