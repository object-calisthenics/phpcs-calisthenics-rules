<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\Metrics\MaxNestingLevel;

use Iterator;
use ObjectCalisthenics\Sniffs\Metrics\MaxNestingLevelSniff;
use Symplify\EasyCodingStandardTester\Testing\AbstractCheckerTestCase;

/**
 * @see MaxNestingLevelSniff
 */
final class MaxNestingLevelSniffTest extends AbstractCheckerTestCase
{
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
