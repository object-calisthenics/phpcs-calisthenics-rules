<?php declare(strict_types=1);

namespace ObjectCalisthenics;

use ObjectCalisthenics\Helper\ClassAnalyzer;
use ObjectCalisthenics\Helper\PropertyFilter;
use PHP_CodeSniffer_File;

/**
 * Track the limit of properties of a given set of types per class.
 * Check for untracked property types per class limit too.
 */
abstract class AbstractPropertyTypePerClassLimitSniff
{
    /**
     * @var int
     */
    protected $trackedMaxCount = 1;

    /**
     * @var int
     */
    protected $untrackedMaxCount = 0;

    /**
     * @var array
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

        if ($this->checkTotalPropertiesAmount()) {
            return;
        }

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

    private function checkTrackedClassPropertyAmount(): string
    {
        $trackedPropertyList = PropertyFilter::getTrackedClassPropertyList($this->propertyList, $this->getTrackedPropertyTypeList());
        $trackedPropertyAmount = count($trackedPropertyList);

        if ($trackedPropertyAmount > $this->trackedMaxCount) {
            $message = 'You have %d properties declared of "%s" type(s), must be less or equals than %d properties in total';
            $error = sprintf($message, $trackedPropertyAmount, implode('", "', $this->getTrackedPropertyTypeList()), $this->trackedMaxCount);

            return $error;
        }

        return '';
    }

    abstract protected function getTrackedPropertyTypeList(): array;

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
            $error = sprintf($message, $untrackedPropertyAmount, 'object instance', $this->untrackedMaxCount);

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

    private function checkTotalPropertiesAmount(): bool
    {
        if (($error = $this->checkTrackedClassPropertyAmount()) !== '') {
            $this->file->addError($error, $this->position);

            return true;
        }

        return false;
    }

    private function checkTrackedPropertiesAmount(): bool
    {
        $errorList = $this->checkTrackedClassPropertyTypeAmount();
        if ($errorList) {
            array_map(
                function ($error) {
                    $this->file->addError($error, $this->position, 'TooManyPropertiesOfType');
                },
                $errorList
            );

            return true;
        }

        return false;
    }
}
