<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\Files;

use ObjectCalisthenics\Sniffs\Files\ClassTraitAndInterfaceLengthSniff;
use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit\Framework\TestCase;

final class ClassTraitAndInterfaceLengthSniffTest extends TestCase
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
            __DIR__ . '/ClassTraitAndInterfaceLengthSniffTest.inc',
            ClassTraitAndInterfaceLengthSniff::class
        );

        $this->assertSame(1, $errorCount);
    }

    public function testInterfaceLengthSniff(): void
    {
        $errorCount = $this->codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__ . '/ClassTraitAndInterfaceLengthSniffTest2.inc',
            ClassTraitAndInterfaceLengthSniff::class
        );

        $this->assertSame(1, $errorCount);
    }

    public function testTraitLengthSniff(): void
    {
        $errorCount = $this->codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__ . '/ClassTraitAndInterfaceLengthSniffTest3.inc',
            ClassTraitAndInterfaceLengthSniff::class
        );

        $this->assertSame(1, $errorCount);
    }
}
