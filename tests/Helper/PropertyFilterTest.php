<?php declare(strict_types = 1);

namespace ObjectCalisthenics\Tests\Helper;

use ObjectCalisthenics\Helper\PropertyFilter;
use PHPUnit\Framework\TestCase;

final class PropertyFilterTest extends TestCase
{
    /**
     * @dataProvider provideProperties
     * @param string[] $properties
     * @param int $nonScalarPropertiesCount
     */
    public function test(array $properties, int $nonScalarPropertiesCount)
    {
        $this->assertCount($nonScalarPropertiesCount, PropertyFilter::filterOutScalarProperties($properties));
    }

    /**
     * @return string[][]
     */
    public function provideProperties(): array
    {
        return [
            [
                [['type' => 'string']], 0
            ],
            [
                [['type' => 'string[]']], 0
            ],
            [
                [['type' => 'bool[][]']], 0
            ]
        ];
    }
}
