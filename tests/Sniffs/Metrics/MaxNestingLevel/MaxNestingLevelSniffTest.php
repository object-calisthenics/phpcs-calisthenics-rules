<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\Metrics\MaxNestingLevel;

use ObjectCalisthenics\Sniffs\Metrics\MaxNestingLevelSniff;
use ObjectCalisthenics\Tests\Sniffs\AbstractSniffTestCase;

final class MaxNestingLevelSniffTest extends AbstractSniffTestCase
{
    public function test(): void
    {
        $this->runSniffTestForDirectory(MaxNestingLevelSniff::class, __DIR__);
    }
}
