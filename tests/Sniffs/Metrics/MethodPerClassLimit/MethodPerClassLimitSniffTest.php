<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\Metrics\MethodPerClassLimit;

use ObjectCalisthenics\Sniffs\Metrics\MethodPerClassLimitSniff;
use ObjectCalisthenics\Tests\Sniffs\AbstractSniffTestCase;

final class MethodPerClassLimitSniffTest extends AbstractSniffTestCase
{
    public function test(): void
    {
        $this->runSniffTestForDirectory(MethodPerClassLimitSniff::class, __DIR__);
    }
}
