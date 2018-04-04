<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\Metrics\PropertyPerClassLimit;

use Iterator;
use Symplify\EasyCodingStandardTester\Testing\AbstractCheckerTestCase;

final class PropertyPerClassLimitSniffTest extends AbstractCheckerTestCase
{
    /**
     * @dataProvider provideCorrectCases()
     */
    public function testCorrectCases(string $file): void
    {
        $this->doTestCorrectFile($file);
    }

    public function provideCorrectCases(): Iterator
    {
        yield [__DIR__ . '/correct/correct.php.inc'];
    }

    /**
     * @dataProvider provideWrongCases()
     */
    public function testWrongToFixed(string $wrongFile): void
    {
        $this->doTestWrongFile($wrongFile);
    }

    public function provideWrongCases(): Iterator
    {
        yield [__DIR__ . '/wrong/wrong.php.inc'];
    }

    protected function provideConfig(): string
    {
        return __DIR__ . '/config.yml';
    }
}
