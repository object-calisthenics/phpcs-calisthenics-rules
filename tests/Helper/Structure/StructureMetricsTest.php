<?php declare(strict_types = 1);

namespace ObjectCalisthenics\Tests\Helper\Structure;

use ObjectCalisthenics\Helper\Structure\StructureMetrics;
use ObjectCalisthenics\Tests\FileFactory;
use PHPUnit\Framework\TestCase;

final class StructureMetricsTest extends TestCase
{
    /**
     * @var int
     */
    private const CLASS_POSITION = 6;

    /**
     * @var int
     */
    private const METHOD_POSITION = 12;

    /**
     * @var FileFactory
     */
    private $fileFactory;

    protected function setUp()
    {
        $this->fileFactory = new FileFactory;
    }

    public function test()
    {
        $file = $this->fileFactory->createFile(__DIR__ . '/StructureMetricsSource/SomeClass.php.inc');

        $classStructureLength = StructureMetrics::getStructureLengthInLines($file, self::CLASS_POSITION);
        $this->assertSame(9, $classStructureLength);

        $methodStructureLength = StructureMetrics::getStructureLengthInLines($file, self::METHOD_POSITION);
        $this->assertSame(4, $methodStructureLength);
    }
}
