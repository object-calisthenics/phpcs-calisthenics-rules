<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\Files;

use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit\Framework\TestCase;

/**
 * @covers \ObjectCalisthenics\Sniffs\NamingConventions\ClassNameLengthSniff
 */
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
            'ObjectCalisthenics.Files.ClassElementLength'
        );

        $this->assertSame(1, $errorCount);
    }

    public function testInterfaceLengthSniff(): void
    {
        $errorCount = $this->codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/ClassElementLengthSniffTest2.inc',
            'ObjectCalisthenics.Files.ClassElementLength'
        );

        $this->assertSame(1, $errorCount);
    }

    public function testTraitLengthSniff(): void
    {
        $errorCount = $this->codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/ClassElementLengthSniffTest3.inc',
            'ObjectCalisthenics.Files.ClassElementLength'
        );

        $this->assertSame(1, $errorCount);
    }
}
