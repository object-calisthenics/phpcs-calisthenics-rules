<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\Files;

use ObjectCalisthenics\Sniffs\Files\ClassElementLengthSniff;
use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit\Framework\TestCase;

final class ClassElementLengthSniffTest extends TestCase
{
    /**
     * @var CodeSnifferRunner
     */
    private $codeSnifferRunner;

    protected function setUp(): void
    {
        $this->codeSnifferRunner = new CodeSnifferRunner();
    }

    public function testClassLengthSniff(): void
    {
        $errorCount = $this->codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/ClassElementLengthSniffTest.inc',
            ClassElementLengthSniff::class
        );

        $this->assertSame(1, $errorCount);
    }

    public function testInterfaceLengthSniff(): void
    {
        $errorCount = $this->codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/ClassElementLengthSniffTest2.inc',
            ClassElementLengthSniff::class
        );

        $this->assertSame(1, $errorCount);
    }

    public function testTraitLengthSniff(): void
    {
        $errorCount = $this->codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/ClassElementLengthSniffTest3.inc',
            ClassElementLengthSniff::class
        );

        $this->assertSame(1, $errorCount);
    }
}
