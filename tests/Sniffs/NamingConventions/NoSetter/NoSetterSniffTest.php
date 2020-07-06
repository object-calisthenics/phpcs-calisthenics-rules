<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\NamingConventions\NoSetter;

use Iterator;
use ObjectCalisthenics\Sniffs\NamingConventions\NoSetterSniff;
use Symplify\EasyCodingStandardTester\Testing\AbstractCheckerTestCase;
use Symplify\SmartFileSystem\SmartFileInfo;

final class NoSetterSniffTest extends AbstractCheckerTestCase
{
    /**
     * @dataProvider provideCorrectCases()
     */
    public function testCorrectCases(string $file): void
    {
        $this->doTestFileInfo(new SmartFileInfo($file));
    }

    public function provideCorrectCases(): Iterator
    {
        yield [__DIR__ . '/correct/correct.php.inc'];
    }

    public function testWrongToFixed(): void
    {
        $wrongFileInfo = new SmartFileInfo(__DIR__ . '/wrong/wrong.php.inc');
        $this->doTestFileInfoWithErrorCountOf($wrongFileInfo, 1);
    }

    protected function getCheckerClass(): string
    {
        return NoSetterSniff::class;
    }
}
