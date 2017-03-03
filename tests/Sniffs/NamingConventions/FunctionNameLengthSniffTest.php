<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\NamingConventions;

use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit\Framework\TestCase;

/**
 * @covers \ObjectCalisthenics\Sniffs\NamingConventions\FunctionNameLengthSniff
 */
final class FunctionNameLengthSniffTest extends TestCase
{
    public function test(): void
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/FunctionNameLengthSniffTest.inc',
            'ObjectCalisthenics.NamingConventions.FunctionNameLength'
        );

        $this->assertSame(2, $errorCount);
    }
}
