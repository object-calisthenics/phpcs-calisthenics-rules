<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\Classes;

use ObjectCalisthenics\Sniffs\Classes\ForbiddenPublicPropertySniff;
use ObjectCalisthenics\Tests\Sniffs\AbstractSniffTestCase;

final class ForbiddenPublicPropertySniffTest extends AbstractSniffTestCase
{
    public function test(): void
    {
        $this->runSniffTestForDirectory(ForbiddenPublicPropertySniff::class, __DIR__);
    }
}
