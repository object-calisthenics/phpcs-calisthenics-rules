<?php declare(strict_types = 1);

namespace ObjectCalisthenics\Tests\Helper;

use ObjectCalisthenics\Helper\Naming;
use ObjectCalisthenics\Tests\FileFactory;
use PHPUnit\Framework\TestCase;

final class NamingTest extends TestCase
{
    /**
     * @var int
     */
    private const CLASS_POSITION = 4;

    /**
     * @var int
     */
    private const CONSTANT_POSITION = 12;

    /**
     * @var int
     */
    private const PROPERTY_POSITION = 25;

    /**
     * @var FileFactory
     */
    private $fileFactory;

    protected function setUp()
    {
        $this->fileFactory = new FileFactory();
    }

    public function test()
    {
        $file = $this->fileFactory->createFile(__DIR__ . '/NamingSource/SomeFile.php.inc');

        $name = Naming::getElementName($file, self::CLASS_POSITION);
        $this->assertSame('SomeClass', $name);

        $name = Naming::getElementName($file, self::CONSTANT_POSITION);
        $this->assertSame('SOME_CONSTANT', $name);

        $name = Naming::getElementName($file, self::PROPERTY_POSITION);
        $this->assertSame('someProperty', $name);
    }
}
