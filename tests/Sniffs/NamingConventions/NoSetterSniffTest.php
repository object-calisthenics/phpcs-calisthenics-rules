<?php

declare(strict_types=1);

namespace ObjectCalisthenics\tests\Sniffs\NamingConventions;

use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit\Framework\TestCase;

/**
 * @covers \ObjectCalisthenics\Sniffs\NamingConventions\NoSetterSniff
 */
class NoSetterSniffTest extends TestCase
{
    public function testSniff()
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $warningCount = $codeSnifferRunner->detectWarningCountInFileForSniff(
            __DIR__.'/NoSetterSniffTest.inc',
            'ObjectCalisthenics.NamingConventions.NoSetter'
        );

        $this->assertSame(1, $warningCount);
    }
}
