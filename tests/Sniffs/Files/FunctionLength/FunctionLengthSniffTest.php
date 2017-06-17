<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\Files\FunctionLengthSniff;

use ObjectCalisthenics\Sniffs\Files\FunctionLengthSniff;
use ObjectCalisthenics\Tests\Sniffs\AbstractSniffTestCase;

final class FunctionLengthSniffTest extends AbstractSniffTestCase
{
    public function test(): void
    {
        $this->runSniffTestForDirectory(FunctionLengthSniff::class, __DIR__);
    }
}
