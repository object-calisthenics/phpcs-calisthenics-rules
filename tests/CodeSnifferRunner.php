<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests;

use PHP_CodeSniffer;
use PHP_CodeSniffer_File;

final class CodeSnifferRunner
{
    /**
     * @var PHP_CodeSniffer
     */
    private $codeSniffer;

    public function __construct()
    {
        $this->codeSniffer = new PHP_CodeSniffer();
    }

    public function detectErrorCountInFileForSniff(string $testedFile, string $sniffName): int
    {
        return $this->processCodeSniffer($testedFile, $sniffName)->getErrorCount();
    }

    private function processCodeSniffer(string $testedFile, string $sniffName): PHP_CodeSniffer_File
    {
        $this->codeSniffer->initStandard(__DIR__.'/../src/ObjectCalisthenics', [$sniffName]);

        return $this->codeSniffer->processFile($testedFile);
    }
}
