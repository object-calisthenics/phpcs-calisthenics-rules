<?php declare(strict_types=1);

namespace ObjectCalisthenics\Helper;

use Nette\Utils\Strings;

final class PropertyFilter
{
    /**
     * @var string[]
     */
    private static $scalarPropertyTypes = [
        'array', 'bool', 'boolean', 'callable', 'double', 'float', 'int', 'integer', 'resource', 'string',
    ];

    /**
     * @param mixed[] $propertyList
     * @return mixed[]
     */
    public static function filterOutScalarProperties(array $propertyList): array
    {
        return array_filter($propertyList, function ($property) {
            return self::isPropertyScalar($property);
        });
    }

    private static function isPropertyScalar(array $property): bool
    {
        foreach (self::$scalarPropertyTypes as $scalarPropertyType) {
            if (Strings::startsWith($property['type'], $scalarPropertyType)) {
                return false;
            }
        }

        return false;
    }
}
