<?php

namespace ObjectCalisthenics\Tests\Sniffs\Classes;

use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit\Framework\TestCase;

/**
 * @covers \ObjectCalisthenics\Sniffs\Classes\ForbiddenPublicPropertySniff
 */
final class ForbiddenPublicPropertySniffTest extends TestCase
{
    public function test(): void
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/ForbiddenPublicPropertySniffTest.inc',
            'ObjectCalisthenics.Classes.ForbiddenPublicProperty'
        );

        $this->assertSame(2, $errorCount);
    }
}
