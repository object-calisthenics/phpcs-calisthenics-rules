<?php

namespace ObjectCalisthenics\Tests;

use PHP_CodeSniffer;
use PHP_CodeSniffer_Exception;
use PHP_CodeSniffer_File;
use PHPUnit_Framework_TestCase;

/**
 * Mirror to https://raw.githubusercontent.com/squizlabs/PHP_CodeSniffer/master/tests/Standards/AbstractSniffUnitTest.php
 * to prevent dependency on PHP_CodeSniffer's tests.
 *
 * Just simpler.
 */
abstract class AbstractSniffUnitTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var PHP_CodeSniffer
     */
    private $phpcs;

    protected function setUp()
    {
        $this->phpcs = new PHP_CodeSniffer();
        $GLOBALS['PHP_CODESNIFFER_CONFIG_DATA'] = [
            'installed_paths' => '/..'
        ];
    }

    public function testSniff()
    {
        $sniffName = $this->detectSniffName();
        $this->phpcs->initStandard('../../../../..', [$sniffName]);

        $failureMessages = array();

        foreach ($testFiles as $testFile) {
            $filename = basename($testFile);

            try {
                $cliValues = $this->getCliValues($filename);
                $this->phpcs->cli->setCommandLineValues($cliValues);
                $phpcsFile = $this->phpcs->processFile($testFile);
            } catch (\Exception $e) {
                $this->fail('An unexpected exception has been caught: '.$e->getMessage());
            }

            $failures        = $this->generateFailureMessages($phpcsFile);
            $failureMessages = array_merge($failureMessages, $failures);
        }

        if (empty($failureMessages) === false) {
            $this->fail(implode(PHP_EOL, $failureMessages));
        }
    }


    /**
     * Generate a list of test failures for a given sniffed file.
     *
     * @param PHP_CodeSniffer_File $file The file being tested.
     *
     * @return array
     * @throws PHP_CodeSniffer_Exception
     */
    public function generateFailureMessages(PHP_CodeSniffer_File $file)
    {
        $testFile = $file->getFilename();

        $foundErrors      = $file->getErrors();
        $expectedErrors   = $this->getErrorList(basename($testFile));

        if (is_array($expectedErrors) === false) {
            throw new PHP_CodeSniffer_Exception('getErrorList() must return an array');
        }

        $allProblems     = array();
        $failureMessages = array();

        foreach ($foundErrors as $line => $lineErrors) {
            foreach ($lineErrors as $column => $errors) {
                if (isset($allProblems[$line]) === false) {
                    $allProblems[$line] = array(
                        'expected_errors'   => 0,
                        'found_errors'      => array(),
                    );
                }

                $foundErrorsTemp = array();
                foreach ($allProblems[$line]['found_errors'] as $foundError) {
                    $foundErrorsTemp[] = $foundError;
                }

                $errorsTemp = array();
                foreach ($errors as $foundError) {
                    $errorsTemp[] = $foundError['message'].' ('.$foundError['source'].')';

                    $source = $foundError['source'];
                    if (in_array($source, $GLOBALS['PHP_CODESNIFFER_SNIFF_CODES']) === false) {
                        $GLOBALS['PHP_CODESNIFFER_SNIFF_CODES'][] = $source;
                    }

                    if ($foundError['fixable'] === true
                        && in_array($source, $GLOBALS['PHP_CODESNIFFER_FIXABLE_CODES']) === false
                    ) {
                        $GLOBALS['PHP_CODESNIFFER_FIXABLE_CODES'][] = $source;
                    }
                }

                $allProblems[$line]['found_errors'] = array_merge($foundErrorsTemp, $errorsTemp);
            }//end foreach

            if (isset($expectedErrors[$line]) === true) {
                $allProblems[$line]['expected_errors'] = $expectedErrors[$line];
            } else {
                $allProblems[$line]['expected_errors'] = 0;
            }

            unset($expectedErrors[$line]);
        }//end foreach

        foreach ($expectedErrors as $line => $numErrors) {
            if (isset($allProblems[$line]) === false) {
                $allProblems[$line] = array(
                    'expected_errors'   => 0,
                    'found_errors'      => array(),
                );
            }

            $allProblems[$line]['expected_errors'] = $numErrors;
        }

        // Order the messages by line number.
        ksort($allProblems);

        foreach ($allProblems as $line => $problems) {
            $numErrors        = count($problems['found_errors']);
            $expectedErrors   = $problems['expected_errors'];

            $errors      = '';
            $foundString = '';

            if ($expectedErrors !== $numErrors) {
                $lineMessage     = "[LINE $line]";
                $expectedMessage = 'Expected ';
                $foundMessage    = 'in '.basename($testFile).' but found ';

                if ($expectedErrors !== $numErrors) {
                    $expectedMessage .= "$expectedErrors error(s)";
                    $foundMessage    .= "$numErrors error(s)";
                    if ($numErrors !== 0) {
                        $foundString .= 'error(s)';
                        $errors      .= implode(PHP_EOL.' -> ', $problems['found_errors']);
                    }
                }

                $fullMessage = "$lineMessage $expectedMessage $foundMessage.";
                if ($errors !== '') {
                    $fullMessage .= " The $foundString found were:".PHP_EOL." -> $errors";
                }

                $failureMessages[] = $fullMessage;
            }//end if
        }//end foreach

        return $failureMessages;

    }//end generateFailureMessages()


    /**
     * Get a list of CLI values to set before the file is tested.
     *
     * @param string $filename The name of the file being tested.
     *
     * @return array
     */
    public function getCliValues($filename)
    {
        return array();

    }//end getCliValues()


    /**
     * Returns the lines where errors should occur.
     *
     * The key of the array should represent the line number and the value
     * should represent the number of errors that should occur on that line.
     *
     * @return array(int => int)
     */
    protected abstract function getErrorList();


    /**
     * @return string
     */
    private function detectSniffName()
    {
        $className = get_class($this);
        $parts = explode('_', $className);

        return $parts[0].'.'.$parts[2].'.'.$parts[3];
    }
}
