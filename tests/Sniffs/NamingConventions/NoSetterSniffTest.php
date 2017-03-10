<?php declare(strict_types=1);

namespace ObjectCalisthenics\tests\Sniffs\NamingConventions;

use ObjectCalisthenics\Sniffs\NamingConventions\NoSetterSniff;
use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit\Framework\TestCase;

final class NoSetterSniffTest extends TestCase
{
    public function test(): void
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/NoSetterSniffTest.inc',
            NoSetterSniff::class
        );

        $this->assertSame(1, $errorCount);
    }
}
