<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests;

use PHP_CodeSniffer\Config;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Ruleset;
use PHP_CodeSniffer\Util\Tokens;

final class FileFactory
{
    public function __construct()
    {
        // legacy compatibility
        if (! defined('PHP_CODESNIFFER_VERBOSITY')) {
            define('PHP_CODESNIFFER_VERBOSITY', 0);
            define('PHP_CODESNIFFER_CBF', false);
            define('PHP_CODESNIFFER_IN_TESTS', true);
        }

        // initialize Token constants
        if (! defined('T_NONE')) {
            new Tokens();
        }
    }

    public function createFile(string $filePath): File
    {
        $config = new Config();
        $ruleset = new Ruleset($config);

        $file = new File($filePath, $ruleset, $config);
        $file->setContent(file_get_contents($filePath));
        $file->parse();

        return $file;
    }

    public function createFileWithSniffClass(string $filePath, string $sniffClass): File
    {
        $config = new Config();
        $ruleset = $this->createRulesetWithConfigAndSniffClass($sniffClass, $config);

        $file = new File($filePath, $ruleset, $config);
        $file->setContent(file_get_contents($filePath));
        $file->parse();

        return $file;
    }

    private function createRulesetWithConfigAndSniffClass(string $sniffClass, Config $config): Ruleset
    {
        $config->sniffs = [$sniffClass];
        $config->standards = ['ObjectCalisthenics'];

        return new Ruleset($config);
    }
}
