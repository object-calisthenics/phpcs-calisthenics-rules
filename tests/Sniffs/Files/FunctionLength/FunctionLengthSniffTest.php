<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\Files\FunctionLength;

use Iterator;
use ObjectCalisthenics\Sniffs\Files\FunctionLengthSniff;
use Symplify\EasyCodingStandardTester\Testing\AbstractCheckerTestCase;
use Symplify\EasyTesting\DataProvider\StaticFixtureFinder;
use Symplify\SmartFileSystem\SmartFileInfo;

final class FunctionLengthSniffTest extends AbstractCheckerTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(SmartFileInfo $wrongFileInfo): void
    {
        $this->doTestFileInfoWithErrorCountOf($wrongFileInfo, 1);
    }

    public function provideData(): Iterator
    {
        return StaticFixtureFinder::yieldDirectory(__DIR__ . '/Fixture');
    }

    protected function getCheckerClass(): string
    {
        return FunctionLengthSniff::class;
    }
}
