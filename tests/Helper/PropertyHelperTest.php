<?php declare(strict_types=1);

namespace ObjectCalisthenics\Tests\Helper;

use ObjectCalisthenics\Helper\PropertyHelper;
use ObjectCalisthenics\Tests\FileFactory;
use PHPUnit\Framework\TestCase;

final class PropertyHelperTest extends TestCase
{
    public function test(): void
    {
        $fileFactory = new FileFactory();
        $file = $fileFactory->createFile(__DIR__ . '/PropertyHelperSource/SomeFile.php.inc');

        $this->assertTrue(PropertyHelper::isProperty($file, 11));
        $this->assertFalse(PropertyHelper::isProperty($file, 22));
        $this->assertFalse(PropertyHelper::isProperty($file, 29));
        $this->assertFalse(PropertyHelper::isProperty($file, 35));
        $this->assertFalse(PropertyHelper::isProperty($file, 39));
    }
}
