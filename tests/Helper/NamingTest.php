<?php declare(strict_types = 1);

namespace ObjectCalisthenics\Tests\Helper;

use ObjectCalisthenics\Helper\Naming;
use ObjectCalisthenics\Tests\FileFactory;
use PHPUnit\Framework\TestCase;

final class NamingTest extends TestCase
{
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

        $name = Naming::getElementName($file, 4);
        $this->assertSame('SomeClass', $name);

        $name = Naming::getElementName($file, 12);
        $this->assertSame('SOME_CONSTANT', $name);

        $name = Naming::getElementName($file, 21);
        $this->assertSame('someProperty', $name);
    }
}
