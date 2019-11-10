<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\Classes;

use Nette\Utils\Strings;
use ObjectCalisthenics\Helper\PropertyHelper;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Util\Tokens;

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
     * @param int $position
     */
    public function process(File $file, $position): void
    {
        if (! PropertyHelper::isProperty($file, $position)) {
            return;
        }

        // skip Sniff classes, they have public properties for configuration (unfortunately)
        if ($this->isSniffClass($file, $position)) {
            return;
        }

        $scopeModifierToken = $this->getPropertyScopeModifier($file, $position);
        if ($scopeModifierToken['code'] === T_PUBLIC) {
            $file->addError(self::ERROR_MESSAGE, $position, self::class);
        }
    }

    private function isSniffClass(File $file, int $position): bool
    {
        $classTokenPosition = (int) $file->findPrevious(T_CLASS, $position);
        $classNameTokenPosition = $file->findNext(T_STRING, $classTokenPosition);

        $classNameToken = $file->getTokens()[$classNameTokenPosition];

        return Strings::endsWith($classNameToken['content'], 'Sniff');
    }

    /**
     * @return mixed[]
     */
    private function getPropertyScopeModifier(File $file, int $position): array
    {
        $scopeModifierPosition = $file->findPrevious(Tokens::$scopeModifiers, ($position - 1));

        return $file->getTokens()[$scopeModifierPosition];
    }
}
