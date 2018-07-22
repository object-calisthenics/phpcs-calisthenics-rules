<?php declare(strict_types=1);

namespace ObjectCalisthenics\tests\Sniffs\NamingConventions;

use ObjectCalisthenics\Sniffs\NamingConventions\NoSetterSniff;
use Symplify\EasyCodingStandardTester\Testing\AbstractCheckerTestCase;

/**
 * @see NoSetterSniff
 */
final class ConfiguredTest extends AbstractCheckerTestCase
{
    public function testCorrectCases(): void
    {
        $this->doTestCorrectFile(__DIR__ . '/correct/correct2.php.inc');
        $this->doTestCorrectFile(__DIR__ . '/correct/correct3.php.inc');
    }

    protected function provideConfig(): string
    {
        return __DIR__ . '/skipping-config.yml';
    }
}
