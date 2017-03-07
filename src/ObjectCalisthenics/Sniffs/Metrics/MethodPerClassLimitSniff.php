<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\Metrics;

use ObjectCalisthenics\Helper\ClassAnalyzer;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

final class MethodPerClassLimitSniff implements Sniff
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
        return [T_CLASS, T_INTERFACE, T_TRAIT];
    }

    /**
     * @param File $file
     * @param int  $position
     */
    public function process(File $file, $position): void
    {
        $methodCount = ClassAnalyzer::getClassMethodCount($file, $position);

        if ($methodCount > $this->maxCount) {
            $tokenType = $file->getTokens()[$position]['content'];

            $message = sprintf(
                '""%s" has too many methods: %d. Can be up to %d methods',
                $tokenType,
                $methodCount,
                $this->maxCount
            );
            $file->addError($message, $position, self::class);
        }
    }
}
