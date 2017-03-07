<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests;

use PHP_CodeSniffer\Config;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Ruleset;
use PHP_CodeSniffer\Util\Tokens;

final class CodeSnifferRunner
{
    public function __construct()
    {
        // legacy compatibility
        if (!defined('PHP_CODESNIFFER_VERBOSITY')) {
            define('PHP_CODESNIFFER_VERBOSITY', 0);
        }

        new Tokens();
    }

    public function detectErrorCountInFileForSniff(string $testedFile, string $sniffName): int
    {
        return $this->processCodeSniffer($testedFile, $sniffName)
            ->getErrorCount();
    }

    private function processCodeSniffer(string $testedFile, string $sniffClass): File
    {
        $file = $this->createFileWithSniffClass($testedFile, $sniffClass);
        $file->process();

        return $file;
    }

    private function createFileWithSniffClass(string $testedFile, string $sniffClass): File
    {
        $config = new Config();
        $config->standards = []; // nulling required, PEAR by default

        $ruleset = new Ruleset($config);
        $ruleset->sniffs = [
            $sniffClass => new $sniffClass(),
        ];
        $ruleset->populateTokenListeners();

        $file = new File($testedFile, $ruleset, $config);
        $file->setContent(file_get_contents($testedFile));

        return $file;
    }
}
