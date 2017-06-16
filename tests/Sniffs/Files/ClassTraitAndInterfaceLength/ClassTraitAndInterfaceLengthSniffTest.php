<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\Files\ClassTraitAndInterfaceLength;

use ObjectCalisthenics\Sniffs\Files\ClassTraitAndInterfaceLengthSniff;
use ObjectCalisthenics\Tests\Sniffs\AbstractSniffTestCase;

final class ClassTraitAndInterfaceLengthSniffTest extends AbstractSniffTestCase
{
    public function test(): void
    {
        $this->runSniffTestForDirectory(ClassTraitAndInterfaceLengthSniff::class, __DIR__);
    }
}
