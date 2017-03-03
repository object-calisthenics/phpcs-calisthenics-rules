<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\NamingConventions;

use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit\Framework\TestCase;

/**
 * @covers \ObjectCalisthenics\Sniffs\NamingConventions\ConstantNameLengthSniff
 */
final class ConstantNameLengthSniffTest extends TestCase
{
    public function test(): void
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/ConstantNameLengthSniffTest.inc',
            'ObjectCalisthenics.NamingConventions.ConstantNameLength'
        );

        $this->assertSame(1, $errorCount);
    }
}
