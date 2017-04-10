<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\NamingConventions;

use ObjectCalisthenics\Helper\Naming;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

final class ClassNameLengthSniff implements Sniff
{
    /**
     * @var string
     */
    private const ERROR_MESSAGE = 'Name "%s" is only %d chars long. Must be at least %d.';

    /**
     * @var int
     */
    public $minLength = 3;

    /**
     * @return int[]
     */
    public function register(): array
    {
        return [T_CLASS, T_CONST, T_FUNCTION];
    }

    /**
     * @param File $file
     * @param int  $position
     */
    public function process(File $file, $position): void
    {
        $elementName = Naming::getElementName($file, $position);

        $length = mb_strlen($elementName);
        if ($length >= $this->minLength) {
            return;
        }

        $message = sprintf(
            self::ERROR_MESSAGE,
            $elementName,
            $length,
            $this->minLength
        );

        $file->addError($message, $position, self::class);
    }
}
