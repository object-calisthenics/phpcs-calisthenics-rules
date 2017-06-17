<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\CodeAnalysis;

use ObjectCalisthenics\Sniffs\CodeAnalysis\OneObjectOperatorPerLineSniff;
use ObjectCalisthenics\Tests\Sniffs\AbstractSniffTestCase;

final class OneObjectOperatorPerLineSniffTest extends AbstractSniffTestCase
{
    public function test(): void
    {
        $this->runSniffTestForDirectory(OneObjectOperatorPerLineSniff::class, __DIR__);
    }
}
