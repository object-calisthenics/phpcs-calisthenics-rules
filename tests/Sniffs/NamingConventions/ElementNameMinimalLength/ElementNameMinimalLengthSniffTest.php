<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs\NamingConventions\ElementNameMinimalLength;

use ObjectCalisthenics\Sniffs\NamingConventions\ElementNameMinimalLengthSniff;
use ObjectCalisthenics\Tests\Sniffs\AbstractSniffTestCase;

final class ElementNameMinimalLengthSniffTest extends AbstractSniffTestCase
{
    public function test(): void
    {
        $this->runSniffTestForDirectory(ElementNameMinimalLengthSniff::class, __DIR__);
    }
}
