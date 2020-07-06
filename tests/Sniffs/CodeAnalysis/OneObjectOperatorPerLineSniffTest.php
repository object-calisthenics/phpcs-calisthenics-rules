<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\CodeAnalysis;

use Iterator;
use ObjectCalisthenics\Sniffs\CodeAnalysis\OneObjectOperatorPerLineSniff;
use Symplify\EasyCodingStandardTester\Testing\AbstractCheckerTestCase;
use Symplify\EasyTesting\DataProvider\StaticFixtureFinder;
use Symplify\SmartFileSystem\SmartFileInfo;

final class OneObjectOperatorPerLineSniffTest extends AbstractCheckerTestCase
{
    /**
     * @dataProvider provideCorrectCases()
     */
    public function testCorrectCases(string $file): void
    {
        $fileInfo = new SmartFileInfo($file);
        $this->doTestFileInfo($fileInfo);
    }

    public function provideCorrectCases(): Iterator
    {
        yield [__DIR__ . '/correct/correct.php.inc'];
    }

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
        return OneObjectOperatorPerLineSniff::class;
    }
}
