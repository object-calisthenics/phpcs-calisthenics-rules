<?php

declare(strict_types = 1);

namespace ObjectCalisthenics\tests\Sniffs\NamingConventions;

use ObjectCalisthenics\Sniffs\NamingConventions\NoSetterSniff;
use PHP_CodeSniffer_File;
use PHPUnit\Framework\TestCase;

/**
 * @covers \ObjectCalisthenics\Sniffs\NamingConventions\NoSetterSniff
 */
class NoSetterSniffTest extends TestCase
{
    /** @var NoSetterSniff */
    private $noSetterSniff;

    /** @var PHP_CodeSniffer_File|\PHPUnit_Framework_MockObject_MockObject */
    private $phpcsFile;

    public function setUp()
    {
        $this->noSetterSniff = new NoSetterSniff();
        $this->phpcsFile = $this->createMock(PHP_CodeSniffer_File::class);
    }

    public function testDetectsStandardSetterMethod()
    {
        $this->phpcsFile
            ->method('getDeclarationName')
            ->willReturn('setCustomer');

        $this->phpcsFile
            ->expects($this->once())
            ->method('addWarning')
            ->with(NoSetterSniff::SETTER_WARNING, 0);

        $this->noSetterSniff->process($this->phpcsFile, 0);
    }

    public function testIgnoresMethodStartingWithSetAndContinuingWithLowercaseLetters()
    {
        $this->phpcsFile
            ->method('getDeclarationName')
            ->willReturn('settings');

        $this->phpcsFile
            ->expects($this->never())
            ->method('addWarning');

        $this->noSetterSniff->process($this->phpcsFile, 0);
    }

    public function testIgnoresMethodsWhichDoNotStartWithSet()
    {
        $this->phpcsFile
            ->method('getDeclarationName')
            ->willReturn('increaseCount');

        $this->phpcsFile
            ->expects($this->never())
            ->method('addWarning');

        $this->noSetterSniff->process($this->phpcsFile, 0);
    }

    public function testRegistersFunctions()
    {
        $this->assertEquals([T_FUNCTION], $this->noSetterSniff->register());
    }
}
