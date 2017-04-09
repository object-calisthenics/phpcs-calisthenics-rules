<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\NamingConventions;

use ObjectCalisthenics\Helper\Naming;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

final class VariableNameLengthSniff implements Sniff
{
    /**
     * @var int
     */
    public $minLength = 3;

    /**
     * @var string[]
     */
    public $allowedShortVariableNames = ['id', 'to', 'i'];

    /**
     * @return int[]
     */
    public function register(): array
    {
        return [T_VARIABLE];
    }

    /**
     * @param File $file
     * @param int  $position
     */
    public function process(File $file, $position): void
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
            'Name "%s" is only %d chars long. Must be at least %d.',
            $variableName,
            $length,
            $this->minLength
        );

        $file->addError($message, $position, self::class);
    }

    private function isAllowedShortVariableName(string $variableName): bool
    {
        return in_array($variableName, $this->allowedShortVariableNames);
    }
}
