<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\NamingConventions;

use ObjectCalisthenics\Helper\Naming;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

final class ClassNameLengthSniff implements Sniff
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
        return [T_CLASS];
    }

    /**
     * @param File $file
     * @param int                  $position
     */
    public function process(File $file, $position): void
    {
        $className = Naming::getElementName($file, $position);

        $length = mb_strlen($className);
        if ($length >= $this->minLength) {
            return;
        }

        $message = sprintf(
            'Name "%s" is only %d chars long. Must be at least %d.',
            $className,
            $length,
            $this->minLength
        );

        $file->addError($message, $position, self::class);
    }
}
