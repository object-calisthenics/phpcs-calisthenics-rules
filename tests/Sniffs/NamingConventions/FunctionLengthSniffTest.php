<?php

namespace ObjectCalisthenics\Tests\Sniffs\NamingConventions;

use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit_Framework_TestCase;

/**
 * @covers ObjectCalisthenics\Sniffs\NamingConventions\FunctionLengthSniff
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
final class FunctionLengthSniffTest extends PHPUnit_Framework_TestCase
{
    public function testSniff()
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/FunctionLengthSniffTest.inc',
            'ObjectCalisthenics.NamingConventions.FunctionLength'
        );

        $this->assertSame(4, $errorCount);
    }
}
