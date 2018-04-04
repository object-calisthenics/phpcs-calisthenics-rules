<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\Metrics\MethodPerClassLimit;

use ObjectCalisthenics\Sniffs\Metrics\MethodPerClassLimitSniff;

final class MethodPerClassLimitSniffTest extends AbstractCheckerTestCase
{
    public function test(): void
    {
        $this->runSniffTestForDirectory(MethodPerClassLimitSniff::class, __DIR__);
    }
}
