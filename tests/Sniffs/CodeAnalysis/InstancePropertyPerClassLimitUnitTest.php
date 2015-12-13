<?php

namespace ObjectCalisthenics\tests\Sniffs\CodeAnalysis;

use ObjectCalisthenics\Tests\CodeSnifferRunner;
use PHPUnit_Framework_TestCase;

/**
 * Instance property per class limit, part of "Use first class collections" OC rule.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
final class InstancePropertyPerClassLimitUnitTest extends PHPUnit_Framework_TestCase
{
    public function testSniff()
    {
        $codeSnifferRunner = new CodeSnifferRunner();
        $errorCount = $codeSnifferRunner->detectErrorCountInFileForSniff(
            __DIR__.'/InstancePropertyPerClassLimitUnitTest.inc',
            'ObjectCalisthenics.CodeAnalysis.InstancePropertyPerClassLimit'
        );

        $this->assertCount(2, $errorCount);
    }
}
