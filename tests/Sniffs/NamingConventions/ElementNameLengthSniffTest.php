<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\NamingConventions;

use ObjectCalisthenics\Sniffs\NamingConventions\ElementNameLengthSniff;
use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit\Framework\TestCase;

final class ElementNameLengthSniffTest extends TestCase
{
    public function test(): void
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__ . '/ElementNameLengthSniffTest.inc',
            ElementNameLengthSniff::class
        );

        $this->assertSame(9, $errorCount);
    }
}
