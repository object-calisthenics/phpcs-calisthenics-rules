<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\ControlStructures;

use ObjectCalisthenics\Sniffs\ControlStructures\NoElseSniff;
use ObjectCalisthenics\Tests\Sniffs\AbstractSniffTestCase;

final class NoElseSniffTest extends AbstractSniffTestCase
{
    public function test(): void
    {
        $this->runSniffTestForDirectory(NoElseSniff::class, __DIR__);
    }
}
