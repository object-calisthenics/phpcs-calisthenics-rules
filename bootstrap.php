<?php

/**
 * Copies a directory recursively.
 *
 * @param string $source The source path to copy.
 * @param string $target The target path to copy to.
 */
function copyDirectory($source, $target)
{
    /** @var $iterator \RecursiveIteratorIterator|\RecursiveDirectoryIterator */
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($iterator as $file) {
        /** @var $file SplFileInfo */
        if ($file->isDir()) {
            mkdir($target . '/' . $iterator->getSubPathName());

            continue;
        }

        copy($file, $target . '/' . $iterator->getSubPathName());
    }
}

/**
 * Removes a directory recursively.
 *
 * @param string $directory The path to the directory to remove.
 */
function removeDirectory($directory)
{
    /** @var $iterator \RecursiveIteratorIterator|\RecursiveDirectoryIterator */
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );

    foreach ($iterator as $file) {
        /** @var $file SplFileInfo */
        if ($file->isDir()) {
            rmdir($file->getRealPath());

            continue;
        }

        unlink($file->getRealPath());
    }

    rmdir($directory);
}

$phpCodeSnifferDir = __DIR__ . '/vendor/squizlabs/php_codesniffer';

if ( ! file_exists($phpCodeSnifferDir)) {
    throw new \RuntimeException(
        'Could not find PHP_CodeSniffer dependency. ' .
        'Did you maybe forget to run "php composer.phar install --prefer-source --dev"?'
    );
}

$sniffTestSuiteFile = $phpCodeSnifferDir . '/tests/Standards/AllSniffs.php';

if ( ! file_exists($sniffTestSuiteFile)) {
    throw new \RuntimeException(
        'Could not find PHP_CodeSniffer test suite. ' .
        'Did you maybe forget to run composer installation with option "--prefer-source"?'
    );
}

require_once __DIR__ . '/vendor/autoload.php';

$calisthenicsStandardDir = $phpCodeSnifferDir . '/CodeSniffer/Standards/ObjectCalisthenics';

if (file_exists($calisthenicsStandardDir)) {
    removeDirectory($calisthenicsStandardDir);
}

mkdir($calisthenicsStandardDir);
mkdir($calisthenicsStandardDir . '/Sniffs');
mkdir($calisthenicsStandardDir . '/Tests');

copy(__DIR__ . '/ruleset.xml', $calisthenicsStandardDir . '/ruleset.xml');

copyDirectory(__DIR__ . '/Sniffs', $calisthenicsStandardDir . '/Sniffs');
copyDirectory(__DIR__ . '/Tests', $calisthenicsStandardDir . '/Tests');

