<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\Classes;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Util\Tokens;
use SlevomatCodingStandard\Helpers\PropertyHelper;

final class ForbiddenPublicPropertySniff implements Sniff
{
    /**
     * @var string
     */
    private const ERROR_MESSAGE = 'Do not use public properties. Use method access instead.';

    /**
     * @return int[]
     */
    public function register(): array
    {
        return [T_VARIABLE];
    }

    /**
     * @param File $file
     * @param int $position
     */
    public function process(File $file, $position): void
    {
        $this->setupLegacyCompatibilitey();
        if (! PropertyHelper::isProperty($file, $position)) {
            return;
        }

        $scopeModifier = $file->findPrevious(Tokens::$scopeModifiers, ($position - 1));

        $tokens = $file->getTokens();
        if ($tokens[$scopeModifier]['code'] === T_PUBLIC) {
            $file->addError(self::ERROR_MESSAGE, $position, self::class);
        }
    }

    private function setupLegacyCompatibilitey(): void
    {
        if (!class_exists('PHP_CodeSniffer_File')) {
            class_alias(File::class, 'PHP_CodeSniffer_File');
        }
    }
}
