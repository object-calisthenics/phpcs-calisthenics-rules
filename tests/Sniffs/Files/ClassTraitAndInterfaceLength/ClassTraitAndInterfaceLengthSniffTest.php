<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\Files\ClassTraitAndInterfaceLength;

use Iterator;
use ObjectCalisthenics\Sniffs\Files\ClassTraitAndInterfaceLengthSniff;
use Symplify\EasyCodingStandardTester\Testing\AbstractCheckerTestCase;
use Symplify\EasyTesting\DataProvider\StaticFixtureFinder;
use Symplify\SmartFileSystem\SmartFileInfo;

final class ClassTraitAndInterfaceLengthSniffTest extends AbstractCheckerTestCase
{
    /**
     * @dataProvider provideWrongCases()
     */
    public function testWrongToFixed(SmartFileInfo $wrongFileInfo): void
    {
        $this->doTestFileInfoWithErrorCountOf($wrongFileInfo, 1);
    }

    public function provideWrongCases(): Iterator
    {
        return StaticFixtureFinder::yieldDirectory(__DIR__ . '/Fixture');
    }

    protected function getCheckerClass(): string
    {
        return ClassTraitAndInterfaceLengthSniff::class;
    }
}
