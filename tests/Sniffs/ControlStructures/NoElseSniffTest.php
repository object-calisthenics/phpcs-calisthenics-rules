<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\ControlStructures;

use Iterator;
use ObjectCalisthenics\Sniffs\ControlStructures\NoElseSniff;
use Symplify\EasyCodingStandardTester\Testing\AbstractCheckerTestCase;
use Symplify\EasyTesting\DataProvider\StaticFixtureFinder;
use Symplify\SmartFileSystem\SmartFileInfo;

final class NoElseSniffTest extends AbstractCheckerTestCase
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
        return NoElseSniff::class;
    }
}
