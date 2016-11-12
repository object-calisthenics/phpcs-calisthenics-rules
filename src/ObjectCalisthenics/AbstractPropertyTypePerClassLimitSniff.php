<?php

declare(strict_types=1);

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

    public function register() : array
    {
        return [T_CLASS, T_TRAIT];
    }

    /**
     * @param PHP_CodeSniffer_File $phpcsFile
     * @param int                  $stackPtr
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $this->propertyList = ClassAnalyzer::getClassProperties($phpcsFile, $stackPtr);

        // Check for tracked property type amount
        if (($error = $this->checkTrackedClassPropertyAmount()) !== '') {
            $phpcsFile->addError($error, $stackPtr, 'TooManyTrackedProperties');

            return;
        }

        // Check for each tracked property type amount
        $errorList = $this->checkTrackedClassPropertyTypeAmount();

        if ($errorList) {
            array_map(
                function ($error) use ($phpcsFile, $stackPtr) {
                    $phpcsFile->addError($error, $stackPtr, 'TooManyPropertiesOfType');
                },
                $errorList
            );

            return;
        }

        $this->checkUntrackedPropertyTypeAmount($phpcsFile, $stackPtr);
    }

    /**
     * @return string
     */
    protected function getUntrackedPropertyType() : string
    {
        return 'untracked';
    }

    private function checkUntrackedPropertyTypeAmount(PHP_CodeSniffer_File $phpcsFile, int $stackPtr)
    {
        if (($error = $this->checkUntrackedClassPropertyAmount()) !== '') {
            $phpcsFile->addError($error, $stackPtr, 'TooManyUntrackedProperties');

            return;
        }
    }

    private function checkTrackedClassPropertyAmount() : string
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

    abstract protected function getTrackedPropertyTypeList() : array;

    private function checkTrackedClassPropertyTypeAmount() : array
    {
        $segregatedPropertyList = $this->getClassPropertiesSegregatedByType();
        $errorList = [];

        foreach ($segregatedPropertyList as $propertyType => $propertyOfTypeList) {
            $propertyOfTypeAmount = count($propertyOfTypeList);
            if ($propertyOfTypeAmount > $this->trackedMaxCount) {
                $message = 'You have %d properties of "%s" type, must be less or equals than %d properties in total';
                $error = sprintf($message, $propertyOfTypeAmount, $propertyType, $this->trackedMaxCount);

                $errorList[] = $error;
            }
        }

        return $errorList;
    }

    private function checkUntrackedClassPropertyAmount() : string
    {
        $untrackedPropertyList = PropertyFilter::filterUntrackedClassPropertyList($this->propertyList, $this->getTrackedPropertyTypeList());
        $untrackedPropertyAmount = count($untrackedPropertyList);

        if ($untrackedPropertyAmount > $this->untrackedMaxCount) {
            $message = 'You have %d properties declared of %s type, must be less or equals than %d properties in total';
            $error = sprintf($message, $untrackedPropertyAmount, $this->getUntrackedPropertyType(), $this->untrackedMaxCount);

            return $error;
        }

        return '';
    }

    private function getClassPropertiesSegregatedByType() : array
    {
        $segregatedPropertyList = [];

        foreach ($this->propertyList as $property) {
            if (!isset($segregatedPropertyList[$property['type']])) {
                $segregatedPropertyList[$property['type']] = [];
            }

            $segregatedPropertyList[$property['type']][] = $property;
        }

        return $segregatedPropertyList;
    }
}
