<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\NamingConventions\ElementNameMinimalLength;

use Iterator;
use ObjectCalisthenics\Sniffs\NamingConventions\ElementNameMinimalLengthSniff;
use Symplify\EasyCodingStandardTester\Testing\AbstractCheckerTestCase;

/**
 * @see ElementNameMinimalLengthSniff
 */
final class ElementNameMinimalLengthSniffTest extends AbstractCheckerTestCase
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
        yield [__DIR__ . '/correct/correct2.php.inc'];
        yield [__DIR__ . '/correct/correct3.php.inc'];
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
        yield [__DIR__ . '/wrong/wrong2.php.inc'];
        yield [__DIR__ . '/wrong/wrong3.php.inc'];
        yield [__DIR__ . '/wrong/wrong4.php.inc'];
        yield [__DIR__ . '/wrong/wrong5.php.inc'];
        yield [__DIR__ . '/wrong/wrong6.php.inc'];
        yield [__DIR__ . '/wrong/wrong7.php.inc'];
        yield [__DIR__ . '/wrong/wrong8.php.inc'];
        yield [__DIR__ . '/wrong/wrong9.php.inc'];
    }

    protected function provideConfig(): string
    {
        return __DIR__ . '/config.yml';
    }
}
