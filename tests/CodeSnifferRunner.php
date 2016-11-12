<?php

declare(strict_types=1);

namespace ObjectCalisthenics\Tests;

use PHP_CodeSniffer;

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

    public function detectErrorCountInFileForSniff(string $testedFile, string $sniffName) : int
    {
        $this->codeSniffer->initStandard(__DIR__.'/../src/ObjectCalisthenics', [$sniffName]);
        $codeSnifferFile = $this->codeSniffer->processFile($testedFile);

        return $codeSnifferFile->getErrorCount();
    }
}
