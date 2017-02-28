<?php

namespace ObjectCalisthenics\Tests\Sniffs\Classes;

use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit\Framework\TestCase;

/**
 * @covers \ObjectCalisthenics\Sniffs\Classes\PropertyVisibilitySniff
 */
final class PropertyVisibilitySniffTest extends TestCase
{
    public function test(): void
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/PropertyVisibilitySniffTest.inc',
            'ObjectCalisthenics.Classes.PropertyVisibility'
        );

        $this->assertSame(2, $errorCount);
    }
}
