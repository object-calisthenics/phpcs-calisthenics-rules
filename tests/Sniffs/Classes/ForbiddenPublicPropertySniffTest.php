<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\Classes;

use ObjectCalisthenics\Sniffs\Classes\ForbiddenPublicPropertySniff;
use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit\Framework\TestCase;

final class ForbiddenPublicPropertySniffTest extends TestCase
{
    public function test(): void
    {

        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__ . '/ForbiddenPublicPropertySniffTest.inc',
            ForbiddenPublicPropertySniff::class
        );

        $this->assertSame(1, $errorCount);
    }
}
