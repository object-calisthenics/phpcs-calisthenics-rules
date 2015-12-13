<?php

namespace ObjectCalisthenics\Tests\Sniffs\Files;

use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit_Framework_TestCase;

/**
 * @covers ObjectCalisthenics\Sniffs\NamingConventions\ClassElementLengthSniff
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
final class ClassElementLengthSniffTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var CodeSnifferRunner
     */
    private $codeSnifferRunner;

    protected function setUp()
    {
        $this->codeSnifferRunner = new CodeSnifferRunner();
    }

    public function testClassLengthSniff()
    {
        $errorCount = $this->codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/ClassElementLengthSniffTest.inc',
            'ObjectCalisthenics.Files.ClassElementLength'
        );

        $this->assertSame(1, $errorCount);
    }

    public function testInterfaceLengthSniff()
    {
        $errorCount = $this->codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/ClassElementLengthSniffTest2.inc',
            'ObjectCalisthenics.Files.ClassElementLength'
        );

        $this->assertSame(1, $errorCount);
    }

    public function testTraitLengthSniff()
    {
        $errorCount = $this->codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/ClassElementLengthSniffTest3.inc',
            'ObjectCalisthenics.Files.ClassElementLength'
        );

        $this->assertSame(1, $errorCount);
    }
}
