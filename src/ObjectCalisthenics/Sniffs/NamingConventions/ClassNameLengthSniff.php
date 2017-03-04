<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\NamingConventions;

use ObjectCalisthenics\Helper\Naming;
use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Sniff;

final class ClassNameLengthSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * @var int
     */
    public $minLength = 3;

    /**
     * @var PHP_CodeSniffer_File
     */
    private $file;

    /**
     * @var int
     */
    private $position;

    /**
     * @return int[]
     */
    public function register(): array
    {
        return [T_CLASS];
    }

    /**
     * @param PHP_CodeSniffer_File $file
     * @param int                  $position
     */
    public function process(PHP_CodeSniffer_File $file, $position): void
    {
        $this->file = $file;
        $this->position = $position;

        $this->processClassName(Naming::getElementName($file, $position));
    }

    private function processClassName(string $functionName): void
    {
        $length = mb_strlen($functionName);
        if ($length >= $this->minLength) {
            return;
        }

        $message = sprintf(
            'Class name is %d chars long. Must be at least %d.',
            $length,
            $this->minLength
        );

        $this->file->addError($message, $this->position, self::class);
    }
}
