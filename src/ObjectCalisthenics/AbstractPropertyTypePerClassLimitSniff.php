<?php

declare(strict_types=1);

namespace ObjectCalisthenics;

use PHP_CodeSniffer_File;

/**
 * Track the limit of properties of a given set of types per class.
 * Check for untracked property types per class limit too.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
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
        $this->propertyList = $this->getClassPropertyList($phpcsFile, $stackPtr);

        // Check for tracked property type amount
        if (($error = $this->checkTrackedClassPropertyAmount($this->propertyList)) !== '') {
            $phpcsFile->addError($error, $stackPtr, 'TooManyTrackedProperties');

            return;
        }

        // Check for each tracked property type amount
        $errorList = $this->checkTrackedClassPropertyTypeAmount($this->propertyList);

        if ($errorList) {
            array_map(
                function ($error) use ($phpcsFile, $stackPtr) {
                    $phpcsFile->addError($error, $stackPtr, 'TooManyPropertiesOfType');
                },
                $errorList
            );

            return;
        }

        // Check for untracked property type amount
        if (($error = $this->checkUntrackedClassPropertyAmount($this->propertyList)) !== '') {
            $phpcsFile->addError($error, $stackPtr, 'TooManyUntrackedProperties');

            return;
        }
    }

    /**
     * @return string
     */
    protected function getUntrackedPropertyType() : string
    {
        return 'untracked';
    }

    /**
     * @return string
     */
    private function checkTrackedClassPropertyAmount(array $propertyList)
    {
        $trackedPropertyList = $this->getTrackedClassPropertyList($propertyList);
        $trackedPropertyAmount = count($trackedPropertyList);

        if ($trackedPropertyAmount > $this->trackedMaxCount) {
            $message = 'You have %d properties declared of "%s" type(s), must be less or equals than %d properties in total';
            $error = sprintf($message, $trackedPropertyAmount, implode('", "', $this->getTrackedPropertyTypeList()), $this->trackedMaxCount);

            return $error;
        }

        return '';
    }

    abstract protected function getTrackedPropertyTypeList() : array;

    private function checkTrackedClassPropertyTypeAmount(array $propertyList) : array
    {
        $segregatedPropertyList = $this->getClassPropertiesSegregatedByType($propertyList);
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

    private function checkUntrackedClassPropertyAmount(array $propertyList) : string
    {
        $untrackedPropertyList = $this->getUntrackedClassPropertyList($propertyList);
        $untrackedPropertyAmount = count($untrackedPropertyList);

        if ($untrackedPropertyAmount > $this->untrackedMaxCount) {
            $message = 'You have %d properties declared of %s type, must be less or equals than %d properties in total';
            $error = sprintf($message, $untrackedPropertyAmount, $this->getUntrackedPropertyType(), $this->untrackedMaxCount);

            return $error;
        }

        return '';
    }

    /**
     * @return array
     */
    private function getClassPropertiesSegregatedByType(array $propertyList)
    {
        $segregatedPropertyList = [];

        foreach ($propertyList as $property) {
            if (!isset($segregatedPropertyList[$property['type']])) {
                $segregatedPropertyList[$property['type']] = [];
            }

            $segregatedPropertyList[$property['type']][] = $property;
        }

        return $segregatedPropertyList;
    }

    // Segregate property types and amount used in class, then loop through and validate.

    private function getTrackedClassPropertyList(array $propertyList) : array
    {
        $trackedPropertyTypeList = $this->getTrackedPropertyTypeList();

        return array_filter(
            $propertyList,
            function ($property) use ($trackedPropertyTypeList) {
                return in_array($property['type'], $trackedPropertyTypeList);
            }
        );
    }

    private function getUntrackedClassPropertyList(array $propertyList) : array
    {
        $trackedPropertyTypeList = $this->getTrackedPropertyTypeList();

        return array_filter(
            $propertyList,
            function ($property) use ($trackedPropertyTypeList) {
                return !in_array($property['type'], $trackedPropertyTypeList);
            }
        );
    }

    private function getClassPropertyList(PHP_CodeSniffer_File $phpcsFile, int $stackPtr) : array
    {
        $tokens = $phpcsFile->getTokens();
        $token = $tokens[$stackPtr];
        $pointer = $token['scope_opener'];
        $propertyList = [];

        while (($pointer = $phpcsFile->findNext(T_VARIABLE, ($pointer + 1), $token['scope_closer'])) !== false) {
            $property = $this->createProperty($phpcsFile, $pointer);

            if (!$property) {
                continue;
            }

            $propertyList[] = $property;
        }

        return $propertyList;
    }

    private function createProperty(PHP_CodeSniffer_File $phpcsFile, int $stackPtr) : array
    {
        $tokens = $phpcsFile->getTokens();
        $property = $tokens[$stackPtr];

        // Is it a property or a random variable?
        if (!(count($property['conditions']) === 1 && in_array(reset($property['conditions']), $this->register()))) {
            return;
        }

        $comment = $this->processMemberComment($phpcsFile, $stackPtr);
        if ($comment === null || $comment === '') {
            return;
        }

        return ['type' => $comment];
    }

    private function processMemberComment(PHP_CodeSniffer_File $phpcsFile, int $stackPtr) : string
    {
        $docCommentPosition = $phpcsFile->findPrevious(T_DOC_COMMENT_STRING, $stackPtr, $stackPtr - 10);
        if ($docCommentPosition) {
            $docCommentToken = $phpcsFile->getTokens()[$docCommentPosition];
            $docComment = $docCommentToken['content'];
            if (false !== strpos($docComment, 'inheritdoc')) {
                return '';
            }

            return $docComment;
        }

        return '';
    }
}
