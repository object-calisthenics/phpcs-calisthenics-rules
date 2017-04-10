<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\NamingConventions;

use ObjectCalisthenics\Sniffs\NamingConventions\ElementNameMinimalLengthSniff;
use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit\Framework\TestCase;

final class ElementNameMinimalLengthSniffTest extends TestCase
{
    public function test(): void
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__ . '/ElementNameMinimalLengthSniffTest.inc',
            ElementNameMinimalLengthSniff::class
        );

        $this->assertSame(9, $errorCount);
    }
}
