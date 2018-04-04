<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\Files\FunctionLengthSniff;

use Iterator;
use ObjectCalisthenics\Sniffs\Files\FunctionLengthSniff;
use Symplify\EasyCodingStandardTester\Testing\AbstractCheckerTestCase;

/**
 * @see FunctionLengthSniff
 */
final class FunctionLengthSniffTest extends AbstractCheckerTestCase
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
        yield [__DIR__ . '/wrong/wrong2.php.inc'];
    }

    protected function provideConfig(): string
    {
        return __DIR__ . '/config.yml';
    }
}
