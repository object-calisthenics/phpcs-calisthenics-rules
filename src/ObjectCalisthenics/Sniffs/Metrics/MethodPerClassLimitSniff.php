<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\Metrics;

use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Sniff;

/**
 * Check for amount of methods per class, part of "Keep your classes small" OC rule.
 */
final class MethodPerClassLimitSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Maximum amount of methods per class.
     *
     * @var int
     */
    protected $maxCount = 10;

    public function register(): array
    {
        return [T_CLASS, T_INTERFACE, T_TRAIT];
    }

    /**
     * {@inheritdoc}
     */
    public function process(PHP_CodeSniffer_File $file, $position): void
    {
        $tokens = $file->getTokens();
        $token = $tokens[$position];
        $tokenType = strtolower(substr($token['type'], 2));
        $methods = $this->getClassMethods($file, $position);
        $methodCount = count($methods);

        if ($methodCount > $this->maxCount) {
            $message = 'Your %s has %d methods, must be less or equals than %d methods';
            $error = sprintf($message, $tokenType, $methodCount, $this->maxCount);

            $file->addError($error, $position, sprintf('%sTooManyMethods', ucfirst($tokenType)));
        }
    }

    private function getClassMethods(PHP_CodeSniffer_File $file, int $position): array
    {
        $pointer = $position;
        $methods = [];

        while (($next = $file->findNext(T_FUNCTION, $pointer + 1)) !== false) {
            $methods[] = $next;

            $pointer = $next;
        }

        return $methods;
    }
}
