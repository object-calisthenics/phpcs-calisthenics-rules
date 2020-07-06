<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\Metrics\MethodPerClassLimit;

use ObjectCalisthenics\Sniffs\Metrics\MethodPerClassLimitSniff;
use Symplify\EasyCodingStandardTester\Testing\AbstractCheckerTestCase;
use Symplify\SmartFileSystem\SmartFileInfo;

final class MethodPerClassLimitSniffTest extends AbstractCheckerTestCase
{
    public function testWrongToFixed(): void
    {
        $fileInfo = new SmartFileInfo(__DIR__ . '/wrong/wrong.php.inc');
        $this->doTestFileInfo($fileInfo);
    }

    protected function getCheckerClass(): string
    {
        return MethodPerClassLimitSniff::class;
    }
}
