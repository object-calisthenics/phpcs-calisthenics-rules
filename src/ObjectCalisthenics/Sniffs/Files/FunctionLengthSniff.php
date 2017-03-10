<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\Files;

use ObjectCalisthenics\AbstractDataStructureLengthSniff;
use PHP_CodeSniffer\Sniffs\Sniff;

final class FunctionLengthSniff extends AbstractDataStructureLengthSniff implements Sniff
{
    /**
     * @var int
     */
    public $maxLength = 20;

    /**
     * @return int[]
     */
    public function register(): array
    {
        return [T_FUNCTION];
    }
}
