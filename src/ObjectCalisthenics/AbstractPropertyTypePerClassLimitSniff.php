<?php

namespace ObjectCalisthenics;

use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Sniff;

/**
 * Track the limit of properties of a given set of types per class.
 * Check for untracked property types per class limit too.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
abstract class AbstractPropertyTypePerClassLimitSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Tracked property type maximum amount.
     *
     * @var int
     */
    public $trackedMaxCount = 1;

    /**
     * Untracked property maximum amount.
     *
     * @var int
     */
    public $untrackedMaxCount = 0;

    /**
     * Retrieve the list of tracked property types.
     *
     * @return array
     */
    abstract protected function getTrackedPropertyTypeList();

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        return [T_CLASS, T_TRAIT];
    }

    /**
     * {@inheritdoc}
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $propertyList = $this->getClassPropertyList($phpcsFile, $stackPtr);

        // Check for tracked property type amount
        if (($error = $this->checkTrackedClassPropertyAmount($propertyList)) !== '') {
            $phpcsFile->addError($error, $stackPtr, 'TooManyTrackedProperties');

            return;
        }

        // Check for each tracked property type amount
        $errorList = $this->checkTrackedClassPropertyTypeAmount($propertyList);

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
        if (($error = $this->checkUntrackedClassPropertyAmount($propertyList)) !== '') {
            $phpcsFile->addError($error, $stackPtr, 'TooManyUntrackedProperties');

            return;
        }
    }

    /**
     * @return string
     */
    protected function getUntrackedPropertyType()
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

    /**
     * @return array
     */
    private function checkTrackedClassPropertyTypeAmount(array $propertyList)
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

    /**
     * @return string
     */
    private function checkUntrackedClassPropertyAmount(array $propertyList)
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

    /**
     * @return array
     */
    private function getTrackedClassPropertyList(array $propertyList)
    {
        $trackedPropertyTypeList = $this->getTrackedPropertyTypeList();

        return array_filter(
            $propertyList,
            function ($property) use ($trackedPropertyTypeList) {
                return in_array($property['type'], $trackedPropertyTypeList);
            }
        );
    }

    /**
     * @return array
     */
    private function getUntrackedClassPropertyList(array $propertyList)
    {
        $trackedPropertyTypeList = $this->getTrackedPropertyTypeList();

        return array_filter(
            $propertyList,
            function ($property) use ($trackedPropertyTypeList) {
                return !in_array($property['type'], $trackedPropertyTypeList);
            }
        );
    }

    /**
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token
     *                                        in the stack passed in $tokens.
     *
     * @return array
     */
    private function getClassPropertyList(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
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

    /**
     * Create a given declared class property metadata.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token
     *                                        in the stack passed in $tokens.
     *
     * @return array
     */
    private function createProperty(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $property = $tokens[$stackPtr];

        // Is it a property or a random variable?
        if (!(count($property['conditions']) === 1 && in_array(reset($property['conditions']), $this->register()))) {
            return;
        }

        $comment = $this->processMemberComment($phpcsFile, $stackPtr);
        if ($comment === null) {
            return;
        }

        return [
            'token' => $property,
            'pointer' => $stackPtr,
            'type' => $comment,
            'modifiers$comment' => $phpcsFile->getMemberProperties($stackPtr),
        ];
    }

    /**
     * Process docblock of property and returns its processed information.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token
     *                                        in the stack passed in $tokens.
     *
     * @return string
     */
    private function processMemberComment(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $docCommentPosition = $phpcsFile->findPrevious(T_DOC_COMMENT_STRING, $stackPtr, $stackPtr - 10);
        if ($docCommentPosition) {
            $docCommentToken = $phpcsFile->getTokens()[$docCommentPosition];

            return $docCommentToken['content'];
        }

        return '';
    }
}
