<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\Metrics;

use ObjectCalisthenics\Helper\ClassAnalyzer;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

final class PropertyPerClassLimitSniff implements Sniff
{
    /**
     * @var string
     */
    private const ERROR_MESSAGE = '"%s" has too many properties: %d. Can be up to %d properties.';

    public int $maxCount = 10;

    /**
     * @return int[]
     */
    public function register(): array
    {
        return [T_CLASS, T_TRAIT];
    }

    /**
     * @param int $position
     */
    public function process(File $file, $position): void
    {
        $propertiesCount = ClassAnalyzer::getClassPropertiesCount($file, $position);

        if ($propertiesCount > $this->maxCount) {
            $tokenType = $file->getTokens()[$position]['content'];

            $message = sprintf(self::ERROR_MESSAGE, $tokenType, $propertiesCount, $this->maxCount);
            $file->addError($message, $position, self::class);
        }
    }
}
