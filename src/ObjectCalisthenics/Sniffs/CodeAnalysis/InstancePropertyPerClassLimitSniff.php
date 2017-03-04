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
    protected $trackedMaxCount = 100;

    /**
     * @var int
     */
    protected $untrackedMaxCount = 5;

    /**
     * @return string[]
     */
    private function getTrackedPropertyTypeList(): array
    {
        return [
            'array',
            'bool',
            'boolean',
            'callable',
            'double',
            'float',
            'int',
            'integer',
            'resource',
            'string',
        ];
    }

    /**
     * @var mixed[]
     */
    private $propertyList;

    /**
     * @var PHP_CodeSniffer_File
     */
    private $file;

    /**
     * @var int
     */
    private $position;

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
        $this->propertyList = ClassAnalyzer::getClassProperties($file, $position);
        $this->file = $file;
        $this->position = $position;

        if ($this->checkTrackedPropertiesAmount()) {
            return;
        }

        $this->checkUntrackedPropertyTypeAmount($file, $position);
    }

    private function checkUntrackedPropertyTypeAmount(PHP_CodeSniffer_File $file, int $position): void
    {
        if (($error = $this->checkUntrackedClassPropertyAmount()) !== '') {
            $file->addError($error, $position, 'TooManyUntrackedProperties');

            return;
        }
    }

    private function checkTrackedClassPropertyTypeAmount(): array
    {
        $segregatedPropertyList = $this->getClassPropertiesSegregatedByType();
        $errorList = [];

        $overLimitPropertyList = array_filter($segregatedPropertyList, function (array $propertyOfTypeList) {
            $propertyOfTypeAmount = count($propertyOfTypeList);

            return $propertyOfTypeAmount > $this->trackedMaxCount;
        });

        foreach ($overLimitPropertyList as $propertyType => $propertyOfTypeList) {
            $errorList[] = sprintf(
                'You have %d properties of "%s" type, must be less or equals than %d properties in total',
                count($propertyOfTypeList),
                $propertyType,
                $this->trackedMaxCount
            );
        }

        return $errorList;
    }

    private function checkUntrackedClassPropertyAmount(): string
    {
        $untrackedPropertyList = PropertyFilter::filterUntrackedClassPropertyList($this->propertyList, $this->getTrackedPropertyTypeList());
        $untrackedPropertyAmount = count($untrackedPropertyList);

        if ($untrackedPropertyAmount > $this->untrackedMaxCount) {
            $message = 'You have %d properties declared of %s type, must be less or equals than %d properties in total';
            $error = sprintf(
                $message,
                $untrackedPropertyAmount,
                'object instance',
                $this->untrackedMaxCount
            );

            return $error;
        }

        return '';
    }

    private function getClassPropertiesSegregatedByType(): array
    {
        $segregatedPropertyList = [];

        foreach ($this->propertyList as $property) {
            $segregatedPropertyList[$property['type']][] = $property;
        }

        return $segregatedPropertyList;
    }

    private function checkTrackedPropertiesAmount(): bool
    {
        $errors = $this->checkTrackedClassPropertyTypeAmount();
        foreach ($errors as $error) {
            $this->file->addError($error, $this->position, self::class);
        }

        return (bool) count($errors);
    }
}
