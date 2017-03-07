<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\CodeAnalysis;

use ObjectCalisthenics\Sniffs\CodeAnalysis\InstancePropertyPerClassLimitSniff;
use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit\Framework\TestCase;

final class InstancePropertyPerClassLimitSniffTest extends TestCase
{
    public function test(): void
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/InstancePropertyPerClassLimitSniffTest.inc',
            InstancePropertyPerClassLimitSniff::class
        );

        $this->assertSame(3, $errorCount);
    }
}
