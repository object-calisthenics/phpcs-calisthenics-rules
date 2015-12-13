<?php

namespace ObjectCalisthenics\Tests;

use PHP_CodeSniffer;
use PHP_CodeSniffer_File;
use PHPUnit_Framework_TestCase;

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

    /**
     * @param string $testedFile
     * @param string $sniffName
     * @return int
     */
    public function detectErrorCountInFileForSniff($testedFile, $sniffName)
    {
        $this->codeSniffer->initStandard('../../../../../src/ObjectCalisthenics', [$sniffName]);
        $codeSnifferFile = $this->codeSniffer->processFile($testedFile);

        return $codeSnifferFile->getErrorCount();
    }
}
