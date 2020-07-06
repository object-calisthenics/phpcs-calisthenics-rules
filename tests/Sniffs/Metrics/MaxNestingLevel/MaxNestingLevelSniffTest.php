<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\Metrics\MaxNestingLevel;

use Iterator;
use ObjectCalisthenics\Sniffs\Metrics\MaxNestingLevelSniff;
use Symplify\EasyCodingStandardTester\Testing\AbstractCheckerTestCase;
use Symplify\EasyTesting\DataProvider\StaticFixtureFinder;
use Symplify\SmartFileSystem\SmartFileInfo;

final class MaxNestingLevelSniffTest extends AbstractCheckerTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(SmartFileInfo $fileInfo): void
    {
        $this->doTestFileInfoWithErrorCountOf($fileInfo, 1);
    }

    public function provideData(): Iterator
    {
        return StaticFixtureFinder::yieldDirectory(__DIR__ . '/Fixture');
    }

    protected function getCheckerClass(): string
    {
        return MaxNestingLevelSniff::class;
    }
}
