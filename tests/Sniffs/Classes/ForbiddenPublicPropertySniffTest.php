<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\Classes;

use Iterator;
use ObjectCalisthenics\Sniffs\Classes\ForbiddenPublicPropertySniff;
use Symplify\EasyCodingStandardTester\Testing\AbstractCheckerTestCase;
use Symplify\EasyTesting\DataProvider\StaticFixtureFinder;
use Symplify\SmartFileSystem\SmartFileInfo;

final class ForbiddenPublicPropertySniffTest extends AbstractCheckerTestCase
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
    public function testWrongToFixed(SmartFileInfo $wrongFile): void
    {
        $this->doTestFileInfoWithErrorCountOf($wrongFile, 1);
    }

    public function provideWrongCases(): Iterator
    {
        return StaticFixtureFinder::yieldDirectory(__DIR__ . '/Fixture');
    }

    protected function getCheckerClass(): string
    {
        return ForbiddenPublicPropertySniff::class;
    }
}
