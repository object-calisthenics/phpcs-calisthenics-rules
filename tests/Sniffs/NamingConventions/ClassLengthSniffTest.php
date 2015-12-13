<?php

namespace ObjectCalisthenics\Tests\Sniffs\NamingConventions;

use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit_Framework_TestCase;

/**
 * @covers ObjectCalisthenics\Sniffs\NamingConventions\ClassLengthSniff
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
final class ClassLengthSniffTest extends PHPUnit_Framework_TestCase
{
    public function testSniff()
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/ClassLengthSniffTest.inc',
            'ObjectCalisthenics.NamingConventions.ClassElementLength'
        );

        $this->assertSame(1, $errorCount);
    }
}
