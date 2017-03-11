<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests;

use PHP_CodeSniffer\Files\File;

final class CodeSnifferRunner
{
    /**
     * @var FileFactory
     */
    private $fileFactory;

    public function __construct()
    {
        $this->fileFactory = new FileFactory();
    }

    public function detectErrorCountInFileForSniff(string $testedFile, string $sniffName): int
    {
        $file = $this->processCodeSniffer($testedFile, $sniffName);

        return $file->getErrorCount();
    }

    private function processCodeSniffer(string $testedFile, string $sniffClass): File
    {
        $file = $this->fileFactory->createFileWithSniffClass($testedFile, $sniffClass);
        $file->process();

        return $file;
    }
}
