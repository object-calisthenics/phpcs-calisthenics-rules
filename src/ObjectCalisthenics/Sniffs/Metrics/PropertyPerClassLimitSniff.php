<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\Metrics;

use ObjectCalisthenics\Helper\ClassAnalyzer;
use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Sniff;

final class PropertyPerClassLimitSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * @var int
     */
    public $maxCount = 10;

    /**
     * @return int[]
     */
    public function register(): array
    {
        return [T_CLASS, T_TRAIT];
    }

    /**
     * @param PHP_CodeSniffer_File $file
     * @param int                  $position
     */
    public function process(PHP_CodeSniffer_File $file, $position): void
    {
        $propertiesCount = ClassAnalyzer::getClassPropertiesCount($file, $position);

        if ($propertiesCount > $this->maxCount) {
            $tokenType = $file->getTokens()[$position]['content'];

            $message = sprintf(
                '""%s" has too many properties: %d. Can be up to %d properties.',
                $tokenType,
                $propertiesCount,
                $this->maxCount
            );
            $file->addError($message, $position, self::class);
        }
    }
}
