<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\Metrics;

use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit\Framework\TestCase;

/**
 * @covers \ObjectCalisthenics\Sniffs\Metrics\PropertyPerClassLimitSniff
 */
final class PropertyPerClassLimitSniffTest extends TestCase
{
    public function test(): void
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/PropertyPerClassLimitSniffTest.inc',
            'ObjectCalisthenics.Metrics.PropertyPerClassLimit'
        );

        $this->assertSame(1, $errorCount);
    }
}
