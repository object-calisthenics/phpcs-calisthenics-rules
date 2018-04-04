<?php declare(strict_types=1);

namespace ObjectCalisthenics\tests\Sniffs\NamingConventions;

use Iterator;
use ObjectCalisthenics\Sniffs\NamingConventions\NoSetterSniff;
use Symplify\EasyCodingStandardTester\Testing\AbstractCheckerTestCase;

/**
 * @see NoSetterSniff
 */
final class NoSetterSniffTest extends AbstractCheckerTestCase
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
