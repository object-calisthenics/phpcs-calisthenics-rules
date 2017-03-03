<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\NamingConventions;

use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit\Framework\TestCase;

/**
 * @covers \ObjectCalisthenics\Sniffs\NamingConventions\VariableNameLengthSniff
 */
final class VariableNameLengthSniffTest extends TestCase
{
    public function test(): void
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/VariableNameLengthSniffTest.inc',
            'ObjectCalisthenics.NamingConventions.VariableNameLength'
        );

        $this->assertSame(8, $errorCount);
    }
}
