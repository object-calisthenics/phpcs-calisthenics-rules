<?php

declare(strict_types=1);

namespace ObjectCalisthenics\Helper;

final class PropertyFilter
{
    public static function filterUntrackedClassPropertyList(array $propertyList, array $trackedPropertyTypeList) : array
    {
        return array_filter(
            $propertyList,
            function ($property) use ($trackedPropertyTypeList) {
                return !in_array($property['type'], $trackedPropertyTypeList);
            }
        );
    }

    public static function getTrackedClassPropertyList(array $propertyList, array $trackedPropertyTypeList) : array
    {
        return array_filter(
            $propertyList,
            function ($property) use ($trackedPropertyTypeList) {
                return in_array($property['type'], $trackedPropertyTypeList);
            }
        );
    }
}
