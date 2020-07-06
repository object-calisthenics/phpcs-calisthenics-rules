<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\Metrics;

use ObjectCalisthenics\Helper\ClassAnalyzer;
use ObjectCalisthenics\Helper\NamingHelper;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

final class MethodPerClassLimitSniff implements Sniff
{
    /**
     * @var string
     */
    private const ERROR_MESSAGE = '%s has too many methods: %d. Can be up to %d methods.';

    public int $maxCount = 10;

    /**
     * @return int[]
     */
    public function register(): array
    {
        return [T_CLASS, T_INTERFACE, T_TRAIT];
    }

    /**
     * @param int $position
     */
    public function process(File $file, $position): void
    {
        $methodCount = ClassAnalyzer::getClassMethodCount($file, $position);

        if ($methodCount > $this->maxCount) {
            $typeName = NamingHelper::getTypeName($file, $position);
            $message = sprintf(self::ERROR_MESSAGE, $typeName, $methodCount, $this->maxCount);

            $file->addError($message, $position, self::class);
        }
    }
}
