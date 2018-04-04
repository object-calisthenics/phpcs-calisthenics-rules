<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\Files\ClassTraitAndInterfaceLength;

use ObjectCalisthenics\Sniffs\Files\ClassTraitAndInterfaceLengthSniff;

final class ClassTraitAndInterfaceLengthSniffTest extends AbstractCheckerTestCase
{
    public function test(): void
    {
        $this->runSniffTestForDirectory(ClassTraitAndInterfaceLengthSniff::class, __DIR__);
    }
}
