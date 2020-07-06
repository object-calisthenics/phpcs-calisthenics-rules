<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\NamingConventions\NoSetter;

use ObjectCalisthenics\Sniffs\NamingConventions\NoSetterSniff;
use Symplify\EasyCodingStandardTester\Testing\AbstractCheckerTestCase;
use Symplify\SmartFileSystem\SmartFileInfo;

/**
 * @see NoSetterSniff
 */
final class ConfiguredTest extends AbstractCheckerTestCase
{
    public function test(): void
    {
        $fileInfo = new SmartFileInfo(__DIR__ . '/correct/correct2.php.inc');
        $this->doTestFileInfo($fileInfo);

        $fileInfo = new SmartFileInfo(__DIR__ . '/correct/correct3.php.inc');
        $this->doTestFileInfo($fileInfo);
    }

    protected function provideConfig(): string
    {
        return __DIR__ . '/skipping-config.yaml';
    }
}
