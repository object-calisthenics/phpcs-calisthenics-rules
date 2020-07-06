<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\Metrics\PropertyPerClassLimit;

use Iterator;
use ObjectCalisthenics\Sniffs\Metrics\PropertyPerClassLimitSniff;
use Symplify\EasyCodingStandardTester\Testing\AbstractCheckerTestCase;
use Symplify\SmartFileSystem\SmartFileInfo;

final class PropertyPerClassLimitSniffTest extends AbstractCheckerTestCase
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

    public function testWrongToFixed(): void
    {
        $fileInfo = new SmartFileInfo(__DIR__ . '/wrong/wrong.php.inc');
        $this->doTestFileInfoWithErrorCountOf($fileInfo, 1);
    }

    protected function getCheckerClass(): string
    {
        return PropertyPerClassLimitSniff::class;
    }
}
