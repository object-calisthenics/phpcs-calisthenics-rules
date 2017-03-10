<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\Files;

use ObjectCalisthenics\Sniffs\Files\FunctionLengthSniff;
use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit\Framework\TestCase;

final class FunctionLengthSniffTest extends TestCase
{
    public function test(): void
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/FunctionLengthSniffTest.inc',
            FunctionLengthSniff::class
        );

        $this->assertSame(2, $errorCount);
    }
}
