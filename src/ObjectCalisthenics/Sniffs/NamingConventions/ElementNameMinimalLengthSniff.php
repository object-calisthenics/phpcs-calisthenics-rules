<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\NamingConventions;

use ObjectCalisthenics\Helper\NamingHelper;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

final class ElementNameMinimalLengthSniff implements Sniff
{
    /**
     * @var string
     */
    private const ERROR_MESSAGE = '%s name "%s" is only %d chars long. Must be at least %d.';

    public int $minLength = 3;

    /**
     * @var string[]
     */
    public array $allowedShortNames = ['i', 'id', 'to', 'up'];

    /**
     * @return int[]
     */
    public function register(): array
    {
        return [T_CLASS, T_TRAIT, T_INTERFACE, T_CONST, T_FUNCTION, T_VARIABLE];
    }

    /**
     * @param int $position
     */
    public function process(File $file, $position): void
    {
        $elementName = NamingHelper::getElementName($file, $position);
        $elementNameLength = mb_strlen($elementName);

        if ($this->shouldBeSkipped($elementNameLength, $elementName)) {
            return;
        }

        $typeName = NamingHelper::getTypeName($file, $position);
        $message = sprintf(self::ERROR_MESSAGE, $typeName, $elementName, $elementNameLength, $this->minLength);
        $file->addError($message, $position, self::class);
    }

    private function shouldBeSkipped(int $elementNameLength, string $elementName): bool
    {
        if ($elementNameLength >= $this->minLength) {
            return true;
        }

        return $this->isShortNameAllowed($elementName);
    }

    private function isShortNameAllowed(string $variableName): bool
    {
        return in_array($variableName, $this->allowedShortNames, true);
    }
}
