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
    public $maxCount = 2;

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
        $properties = ClassAnalyzer::getClassProperties($file, $position);

        $objectOnlyProperties = PropertyFilter::filterOutScalarProperties($properties);
        $propertyCountByType = $this->countPropertiesByType($objectOnlyProperties);

        foreach ($propertyCountByType as $type => $count) {

            if ($count <= $this->maxCount) {
                continue;
            }

            $message = sprintf(
                'There are %d properties of "%s" type. Can be up to %d properties in total.',
                $count,
                $type,
                $this->maxCount
            );

            $file->addError($message, $position, self::class);
        }
    }

    /**
     * @return int[]
     */
    private function countPropertiesByType(array $properties): array
    {
        $propertyCountByType = [];

        foreach ($properties as $property) {
            $counter = $propertyCountByType[$property['type']] ?? 0;
            $propertyCountByType[$property['type']] = ++$counter;
        }

        return $propertyCountByType;
    }
}
