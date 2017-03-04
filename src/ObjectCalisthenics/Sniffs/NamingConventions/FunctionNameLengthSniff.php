<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\NamingConventions;

use ObjectCalisthenics\Helper\Naming;
use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Sniff;

final class FunctionNameLengthSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * @var int
     */
    public $minLength = 3;

    /**
     * @return int[]
     */
    public function register(): array
    {
        return [T_FUNCTION];
    }

    /**
     * @param PHP_CodeSniffer_File $file
     * @param int                  $position
     */
    public function process(PHP_CodeSniffer_File $file, $position): void
    {
        $functionName = Naming::getElementName($file, $position);

        $length = mb_strlen($functionName);
        if ($length >= $this->minLength) {
            return;
        }

        $message = sprintf(
            'Name "%s" is only %d chars long. Must be at least %d.',
            $functionName,
            $length,
            $this->minLength
        );

        $file->addError($message, $position, self::class);
    }
}
