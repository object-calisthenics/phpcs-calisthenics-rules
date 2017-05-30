<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Sniffs;

use PHP_CodeSniffer\Sniffs\Sniff;
use PhpCsFixer\Fixer\FixerInterface;
use SplFileInfo;
use Symplify\EasyCodingStandard\ChangedFilesDetector\Contract\ChangedFilesDetectorInterface;
use Symplify\EasyCodingStandard\Contract\SkipperInterface;
use Symplify\EasyCodingStandard\Error\ErrorCollector;
use Symplify\EasyCodingStandard\Error\ErrorSorter;
use Symplify\EasyCodingStandard\SniffRunner\File\File;
use Symplify\EasyCodingStandard\SniffRunner\Fixer\Fixer;
use Symplify\EasyCodingStandard\SniffRunner\Parser\FileToTokensParser;
use Symplify\EasyCodingStandard\SniffRunner\TokenDispatcher\Event\FileTokenEvent;
use Symplify\EasyCodingStandard\SniffRunner\TokenDispatcher\TokenDispatcher;

/**
 * Copied from https://github.com/Symplify/Symplify/blob/master/packages/CodingStandard/tests/Sniffs/SniffRunner.php
 */
final class SniffRunner
{
    public static function getErrorCountForSniffInFile(string $sniffClass, SplFileInfo $fileInfo): int
    {
        $errorDataCollector = self::createErrorDataCollector();
        $sniffDispatcher = self::createSniffDispatcherWithSniff($sniffClass);
        $file = self::createFileFromFilePath($fileInfo->getPathname(), $errorDataCollector);
        foreach ($file->getTokens() as $stackPointer => $token) {
            $sniffDispatcher->dispatchToken(
                $token['code'],
                new FileTokenEvent($file, $stackPointer)
            );
        }
        return $errorDataCollector->getErrorCount();
    }

    public static function getFixedContentForSniffInFile(string $sniffClass, SplFileInfo $fileInfo): string
    {
        $sniffDispatcher = self::createSniffDispatcherWithSniff($sniffClass);
        $file = self::createFileFromFilePath($fileInfo->getPathname());
        foreach ($file->getTokens() as $stackPointer => $token) {
            $sniffDispatcher->dispatchToken(
                $token['code'],
                new FileTokenEvent($file, $stackPointer)
            );
        }
        $fixer = $file->fixer;
        return $fixer->getContents();
    }

    private static function createSniffDispatcherWithSniff(string $sniffClass): TokenDispatcher
    {
        $sniffDispatcher = new TokenDispatcher(self::createSkipper());
        $sniffDispatcher->addSniffListeners([new $sniffClass]);
        return $sniffDispatcher;
    }

    private static function createErrorDataCollector(): ErrorCollector
    {
        $dummyChangedFilesDetector = self::createDummyChangedFilesDetector();
        return new ErrorCollector(new ErrorSorter, $dummyChangedFilesDetector);
    }

    private static function createFileFromFilePath(
        string $filePath,
        ?ErrorCollector $errorDataCollector = null
    ): File {
        $fileToTokenParser = new FileToTokensParser;
        $errorDataCollector = $errorDataCollector ?: self::createErrorDataCollector();
        $tokens = $fileToTokenParser->parseFromFilePath($filePath);
        $fixer = new Fixer;
        $file = new File($filePath, $tokens, $fixer, $errorDataCollector, true);
        $fixer = $file->fixer;
        $fixer->startFile($file);
        return $file;
    }

    private static function createDummyChangedFilesDetector(): ChangedFilesDetectorInterface
    {
        return new class implements ChangedFilesDetectorInterface {
            public function addFile(string $filePath): void
            {
            }
            public function invalidateFile(string $filePath): void
            {
            }
            public function hasFileChanged(string $filePath): bool
            {
                return true;
            }
            public function clearCache(): void
            {
            }
        };
    }

    private static function createSkipper(): SkipperInterface
    {
        return new class implements SkipperInterface
        {
            /**
             * @param Sniff|FixerInterface|string $checker
             */
            public function shouldSkipCheckerAndFile($checker, string $relativeFilePath): bool
            {
                return false;
            }
        };
    }
}