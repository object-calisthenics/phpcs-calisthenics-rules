<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\CodeAnalysis;

use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit\Framework\TestCase;

/**
 * @covers \ObjectCalisthenics\Sniffs\CodeAnalysis\ArrayPropertyPerClassLimitSniff
 */
final class ArrayPropertyPerClassLimitSniffTest extends TestCase
{
    public function testSniff()
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/ArrayPropertyPerClassLimitSniffTest.inc',
            'ObjectCalisthenics.CodeAnalysis.ArrayPropertyPerClassLimit'
        );

        $this->assertSame(2, $errorCount);
    }
}
