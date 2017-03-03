<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\NamingConventions;

use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit\Framework\TestCase;

/**
 * @covers \ObjectCalisthenics\Sniffs\NamingConventions\ClassNameLengthSniff
 */
final class ClassNameLengthSniffTest extends TestCase
{
    public function test(): void
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/ClassNameLengthSniffTest.inc',
            'ObjectCalisthenics.NamingConventions.ClassNameLength'
        );

        $this->assertSame(1, $errorCount);
    }
}
