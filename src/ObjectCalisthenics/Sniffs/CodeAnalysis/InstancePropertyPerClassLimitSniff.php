<?php declare(strict_types=1);

namespace ObjectCalisthenics\Sniffs\CodeAnalysis;

use ObjectCalisthenics\Helper\ClassAnalyzer;
use ObjectCalisthenics\Helper\PropertyFilter;
use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Sniff;

final class InstancePropertyPerClassLimitSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * @var int
     */
    public $maxCount = 5;

    /**
     * @return int[]
     */
    public function register(): array
    {
        return [T_CLASS, T_TRAIT];
    }

    /**
     * @param PHP_CodeSniffer_File $file
     * @param int                  $position
     */
    public function process(PHP_CodeSniffer_File $file, $position): void
    {
        $propertyList = ClassAnalyzer::getClassProperties($file, $position);

        $groupedObjectPropertyList = PropertyFilter::filterOutScalarProperties($propertyList);
        $propertyCountByType = $this->countPropertiesByType($groupedObjectPropertyList);

        foreach ($propertyCountByType as $type => $count) {
            if ($count > $this->maxCount) {
                $message = sprintf(
                    'There are %d properties of "%s" type. Can be up to %d properties in total.',
                    $count,
                    $type,
                    $this->maxCount
                );

                $file->addError($message, $position, self::class);
            }
        }
    }

    /**
     * @return int[]
     */
    private function countPropertiesByType(array $properties): array
    {
        $groupedProperties = [];
        foreach ($properties as $property) {
            $groupedProperties[$property['type']][] = $property;
        }

        $propertyCountByType = [];
        foreach ($groupedProperties as $type => $groupedProperty) {
            $propertyCountByType[$type] = count($groupedProperty);
        }

        return $propertyCountByType;
    }
}
