<?php

namespace ObjectCalisthenics\Tests\Sniffs\NamingConventions;

use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit_Framework_TestCase;

/**
 * @covers ObjectCalisthenics\Sniffs\NamingConventions\ConstantLengthSniff
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
final class ConstantLengthSniffTest extends PHPUnit_Framework_TestCase
{
    public function testSniff()
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/ConstantLengthSniffTest.inc',
            'ObjectCalisthenics.NamingConventions.ConstantLength'
        );

        $this->assertSame(2, $errorCount);
    }
}
