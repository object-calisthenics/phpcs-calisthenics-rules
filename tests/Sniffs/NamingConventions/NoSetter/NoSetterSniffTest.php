<?php declare(strict_types=1);

namespace ObjectCalisthenics\tests\Sniffs\NamingConventions;

use ObjectCalisthenics\Sniffs\NamingConventions\NoSetterSniff;
use ObjectCalisthenics\Tests\Sniffs\AbstractSniffTestCase;

final class NoSetterSniffTest extends AbstractSniffTestCase
{
    public function test(): void
    {
        $this->runSniffTestForDirectory(NoSetterSniff::class, __DIR__);
    }
}
