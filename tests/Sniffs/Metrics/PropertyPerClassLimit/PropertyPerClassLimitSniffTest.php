<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\Metrics\PropertyPerClassLimit;

use ObjectCalisthenics\Sniffs\Metrics\PropertyPerClassLimitSniff;
use ObjectCalisthenics\Tests\Sniffs\AbstractSniffTestCase;

final class PropertyPerClassLimitSniffTest extends AbstractSniffTestCase
{
    public function test(): void
    {
        $this->runSniffTestForDirectory(PropertyPerClassLimitSniff::class, __DIR__);
    }
}
