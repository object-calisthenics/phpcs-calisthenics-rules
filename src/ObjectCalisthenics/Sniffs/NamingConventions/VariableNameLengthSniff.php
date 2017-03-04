<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\NamingConventions;

use ObjectCalisthenics\Helper\Naming;
use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Sniff;

final class VariableNameLengthSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * @var int
     */
    public $minLength = 3;

    /**
     * @var string[]
     */
    public $allowedShortVariableNames = ['id'];

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
        return [T_VARIABLE];
    }

    /**
     * @param PHP_CodeSniffer_File $file
     * @param int                  $position
     */
    public function process(PHP_CodeSniffer_File $file, $position): void
    {
        $variableName = Naming::getElementName($file, $position);

        $length = mb_strlen($variableName);
        if ($length >= $this->minLength) {
            return;
        }

        if ($this->isAllowedShortVariableName($variableName)) {
            return;
        }

        $message = sprintf(
            'Name "%s" is %d chars long. Must be at least %d.',
            $variableName,
            $length,
            $this->minLength
        );

        $file->addError($message, $this->position, self::class);
    }

    private function isAllowedShortVariableName(string $variableName): bool
    {
        return in_array($variableName, $this->allowedShortVariableNames);
    }
}
