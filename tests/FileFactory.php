<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests;

use Exception;
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
            new Tokens;
        }
    }

    public function createFile(string $filePath): File
    {
        $config = new Config;
        $ruleset = new Ruleset($config);

        $file = new File($filePath, $ruleset, $config);

        $fileContent = @file_get_contents($file);
        if (false === $fileContent) {
            throw new Exception("Unable to read file '$file'. ");
        }

        $file->setContent($fileContent);
        $file->parse();

        return $file;
    }
}
