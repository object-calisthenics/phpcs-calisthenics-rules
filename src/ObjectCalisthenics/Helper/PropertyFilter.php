<?php declare(strict_types=1);

namespace ObjectCalisthenics\Helper;

final class PropertyFilter
{
    /**
     * @var string[]
     */
    private static $scalarPropertyTypes = [
        'array', 'bool', 'boolean', 'callable', 'double', 'float', 'int', 'integer', 'resource', 'string',
    ];

    public static function filterOutScalarProperties(array $propertyList): array
    {
        return array_filter($propertyList, function ($property) {
            return ! in_array($property['type'], self::$scalarPropertyTypes, true);
        });
    }
}
