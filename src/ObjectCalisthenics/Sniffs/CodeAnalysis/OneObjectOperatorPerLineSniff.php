<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\CodeAnalysis;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

final class OneObjectOperatorPerLineSniff implements Sniff
{
    /**
     * @var File
     */
    private $file;

    /**
     * @var int
     */
    private $position;

    /**
     * @var array
     */
    private $callerTokens;

    /**
     * mixed[]
     */
    private $tokens;

    /**
     * @return int[]
     */
    public function register(): array
    {
        return [T_VARIABLE];
    }

    /**
     * @param File $file
     * @param int  $position
     */
    public function process(File $file, $position): void
    {
        $this->file = $file;
        $this->position = $position;
        $this->tokens = $file->getTokens();

        $this->callerTokens = [];

//        $tokens = $file->getTokens();
        $pointer = $this->ignoreWhitespace($position + 1);

        $token = $this->tokens[$position];
        $isOwnCall = ($token['content'] === '$this');

        $this->handleObjectOperators($pointer, $isOwnCall);
    }

    private function ignoreWhitespace(int $start): int
    {
        $pointer = $start;

        while ($this->tokens[$pointer]['code'] === T_WHITESPACE) {
            ++$pointer;
        }

        return $pointer;
    }

    private function handleTwoObjectOperators(bool $isOwnCall): void
    {
        if ($this->callerTokens && !$isOwnCall) {
            $this->file->addError('Only one object operator per line.', $this->position, self::class);
        }
    }

    private function handleExcludedFluentInterfaces(array $tmpToken, string $tmpTokenType): void
    {
        if (!$this->callerTokens) {
            return;
        }

        $memberTokenCount = count($this->callerTokens);
        $memberToken = end($this->callerTokens);
        $memberTokenType = $memberToken['type'];

        if (
            ($memberTokenType === 'property' && $tmpTokenType === 'property') ||
            ($memberTokenType === 'method' && $tmpTokenType === 'property') ||
            ($memberTokenType === 'method' && $tmpTokenType === 'method' && $memberTokenCount > 1 && $memberToken['token']['content'] !== $tmpToken['content'])
        ) {
            $this->file->addError('Only one object operator per line.', $this->position, self::class);
        }
    }

    private function handleObjectOperators(int $pointer, bool $isOwnCall): void
    {
        while ($this->tokens[$pointer]['code'] === T_OBJECT_OPERATOR) {
            $tmpToken = $this->tokens[++$pointer];
            $pointer = $this->ignoreWhitespace($pointer + 1);
            $tmpTokenType = $this->getTokenType($this->tokens[$pointer]);

            // Look for second object operator token on same statement
            $this->handleTwoObjectOperators($isOwnCall);
            $this->handleExcludedFluentInterfaces($tmpToken, $tmpTokenType);

            $this->callerTokens[] = [
                'token' => $tmpToken,
                'type' => $tmpTokenType,
            ];

            $pointer = $this->movePointerToNextObject($pointer);
        }
    }

    private function getTokenType(array $token): string
    {
        if ($token['code'] === T_OPEN_PARENTHESIS) {
            return 'method';
        }

        return 'property';
    }

    private function movePointerToNextObject(int $pointer): int
    {
        $token = $this->tokens[$pointer];

        // Ignore "(" ... ")" in a method call by moving pointer after close parenthesis token
        if ($token['code'] === T_OPEN_PARENTHESIS) {
            $pointer = $token['parenthesis_closer'] + 1;
        }

        return $this->ignoreWhitespace($pointer);
    }
}
