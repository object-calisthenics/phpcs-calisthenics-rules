<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\CodeAnalysis;

use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit\Framework\TestCase;

/**
 * @covers \ObjectCalisthenics\Sniffs\CodeAnalysis\InstancePropertyPerClassLimitSniff
 */
final class InstancePropertyPerClassLimitSniffTest extends TestCase
{
    public function testSniff()
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/InstancePropertyPerClassLimitSniffTest.inc',
            'ObjectCalisthenics.CodeAnalysis.InstancePropertyPerClassLimit'
        );

        $this->assertSame(2, $errorCount);
    }
}
