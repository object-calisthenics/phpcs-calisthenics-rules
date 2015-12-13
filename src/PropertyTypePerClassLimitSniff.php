<?php

namespace ObjectCalisthenics;

use PHP_CodeSniffer_Sniff;

/**
 * Track the limit of properties of a given set of types per class. Check for untracked property types per class limit too.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
abstract class PropertyTypePerClassLimitSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Tracked property type maximum amount.
     *
     * @var integer
     */
    public $trackedMaxCount = 1;

    /**
     * Tracked property absolute maximum amount.
     *
     * @var integer
     */
    public $trackedAbsoluteMaxCount = 1;

    /**
     * Untracked property absolute maximum amount.
     *
     * @var integer
     */
    public $untrackedAbsoluteMaxCount = 0;

    /**
     * Supported list of tokenizers supported by this sniff.
     *
     * @var array
     */
    public $supportedTokenizers = array('PHP');

    /**
     * Retrieve the list of tracked property types.
     *
     * @return array
     */
    abstract protected function getTrackedPropertyTypeList();

    /**
     * Registers the tokens that this sniff wants to listen for.
     *
     * @return integer[]
     */
    public function register()
    {
        return array(
            T_CLASS,
            T_TRAIT,
        );
    }

    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param \PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param integer               $stackPtr  The position of the current token
     *                                         in the stack passed in $tokens.
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $propertyList = $this->getClassPropertyList($phpcsFile, $stackPtr);

        // Check for tracked property type absolute amount
        if (($error = $this->checkTrackedClassPropertyAmount($propertyList)) !== '') {
            $phpcsFile->addError($error, $stackPtr, 'TooManyTrackedProperties');

            return;
        }

        // Check for each tracked property type amount
        $errorList = $this->checkTrackedClassPropertyTypeAmount($propertyList);

        if ($errorList) {
            array_map(
                function ($error) use ($phpcsFile, $stackPtr)
                {
                    $phpcsFile->addError($error, $stackPtr, 'TooManyPropertiesOfType');
                },
                $errorList
            );

            return;
        }

        // Check for untracked property type absolute amount
        if (($error = $this->checkUntrackedClassPropertyAmount($propertyList)) !== '') {
            $phpcsFile->addError($error, $stackPtr, 'TooManyUntrackedProperties');

            return;
        }
    }

    /**
     * Retrieve the untracked string representation.
     *
     * @return string
     */
    protected function getUntrackedPropertyType()
    {
        return 'untracked';
    }

    /**
     * Check for tracked class properties amount.
     *
     * @param array $propertyList
     *
     * @return string
     */
    protected function checkTrackedClassPropertyAmount(array $propertyList)
    {
        $trackedPropertyList   = $this->getTrackedClassPropertyList($propertyList);
        $trackedPropertyAmount = count($trackedPropertyList);

        if ($trackedPropertyAmount > $this->trackedAbsoluteMaxCount) {
            $message = 'You have %d properties declared of "%s" type(s), must be less or equals than %d properties in total';
            $error   = sprintf($message, $trackedPropertyAmount, implode('", "', $this->getTrackedPropertyTypeList()), $this->trackedAbsoluteMaxCount);

            return $error;
        }

        return '';
    }

    /**
     * Check for tracked class property types amount.
     *
     * @param array $propertyList
     *
     * @return array
     */
    protected function checkTrackedClassPropertyTypeAmount(array $propertyList)
    {
        $segregatedPropertyList = $this->getClassPropertiesSegregatedByType($propertyList);
        $errorList              = array();

        foreach ($segregatedPropertyList as $propertyType => $propertyOfTypeList) {
            $propertyOfTypeAmount = count($propertyOfTypeList);

            if ($propertyOfTypeAmount > $this->trackedMaxCount) {
                $message = 'You have %d properties of "%s" type, must be less or equals than %d properties in total';
                $error   = sprintf($message, $propertyOfTypeAmount, $propertyType, $this->trackedMaxCount);

                $errorList[] = $error;
            }
        }

        return $errorList;
    }

    /**
     * Check for untracked class properties amount.
     *
     * @param array $propertyList
     *
     * @return string
     */
    protected function checkUntrackedClassPropertyAmount(array $propertyList)
    {
        $untrackedPropertyList   = $this->getUntrackedClassPropertyList($propertyList);
        $untrackedPropertyAmount = count($untrackedPropertyList);

        if ($untrackedPropertyAmount > $this->untrackedAbsoluteMaxCount) {
            $message = 'You have %d properties declared of %s type, must be less or equals than %d properties in total';
            $error   = sprintf($message, $untrackedPropertyAmount, $this->getUntrackedPropertyType(), $this->untrackedAbsoluteMaxCount);

            return $error;
        }

        return '';
    }

    /**
     * Retrieve class properties segregated by data type.
     *
     * @param array $propertyList
     *
     * @return array
     */
    protected function getClassPropertiesSegregatedByType(array $propertyList)
    {
        $segregatedPropertyList = array();

        foreach ($propertyList as $property) {
            if ( ! isset($segregatedPropertyList[$property['type']])) {
                $segregatedPropertyList[$property['type']] = array();
            }

            $segregatedPropertyList[$property['type']][] = $property;
        }

        return $segregatedPropertyList;
    }

    // Segregate property types and amount used in class, then loop through and validate.

    /**
     * Retrieve the list of tracked class properties.
     *
     * @param array $propertyList List of declared class properties.
     *
     * @return array
     */
    protected function getTrackedClassPropertyList(array $propertyList)
    {
        $trackedPropertyTypeList = $this->getTrackedPropertyTypeList();

        return array_filter(
            $propertyList,
            function ($property) use ($trackedPropertyTypeList)
            {
                return in_array($property['type'], $trackedPropertyTypeList);
            }
        );
    }

    /**
     * Retrieve the list of untracked class properties.
     *
     * @param array $propertyList List of declared class properties.
     *
     * @return array
     */
    protected function getUntrackedClassPropertyList(array $propertyList)
    {
        $trackedPropertyTypeList = $this->getTrackedPropertyTypeList();

        return array_filter(
            $propertyList,
            function ($property) use ($trackedPropertyTypeList)
            {
                return ! in_array($property['type'], $trackedPropertyTypeList);
            }
        );
    }

    /**
     * Retrieve all declared class properties.
     *
     * @param \PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param integer               $stackPtr  The position of the current token
     *                                         in the stack passed in $tokens.
     *
     * @return array
     */
    protected function getClassPropertyList(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens       = $phpcsFile->getTokens();
        $token        = $tokens[$stackPtr];
        $pointer      = $token['scope_opener'];
        $propertyList = array();

        while (($pointer = $phpcsFile->findNext(T_VARIABLE, ($pointer + 1), $token['scope_closer'])) !== false) {
            $property = $this->createProperty($phpcsFile, $pointer);

            if ( ! $property) {
                continue;
            }

            $propertyList[] = $property;
        }

        return $propertyList;
    }

    /**
     * Create a given declared class property metadata.
     *
     * @param \PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param integer               $stackPtr  The position of the current token
     *                                         in the stack passed in $tokens.
     *
     * @return array
     */
    private function createProperty(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens   = $phpcsFile->getTokens();
        $property = $tokens[$stackPtr];

        // Is it a property or a random variable?
        if ( ! (count($property['conditions']) === 1 && in_array(reset($property['conditions']), $this->register()))) {
            return null;
        }

        // If comment couldnt be properly parsed, error was already added.
        if (($comment = $this->processMemberComment($phpcsFile, $stackPtr)) === null) {
            return null;
        }

        $varDoc = $comment->getVar();

        // If var tag in docblock couldnt be properly read (ie. inheritdoc), error should be added.
        if ( ! $varDoc) {
            $error = sprintf('Unable to retrieve data type of property "%s"', $property['content']);

            $phpcsFile->addError($error, $stackPtr, 'InvalidPropertyType');

            return null;
        }

        return array(
            'token'     => $property,
            'pointer'   => $stackPtr,
            'type'      => $varDoc->getContent(),
            'modifiers' => $phpcsFile->getMemberProperties($stackPtr),
        );
    }

    /**
     * Process docblock of property and returns its processed information.
     *
     * @param \PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param integer               $stackPtr  The position of the current token
     *                                         in the stack passed in $tokens.
     *
     * @return null|\PHP_CodeSniffer_CommentParser_MemberCommentParser
     */
    private function processMemberComment(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $commentEnd    = $phpcsFile->findPrevious(T_DOC_COMMENT, ($stackPtr - 3));
        $commentStart  = $phpcsFile->findPrevious(T_DOC_COMMENT, ($commentEnd - 1), null, true) + 1;
        $commentString = $phpcsFile->getTokensAsString($commentStart, ($commentEnd - $commentStart + 1));

        // Parse the header comment docblock.
        try {
            $commentParser = new PHP_CodeSniffer_CommentParser_MemberCommentParser($commentString, $phpcsFile);

            $commentParser->parse();
        } catch (PHP_CodeSniffer_CommentParser_ParserException $exception) {
            $line = ($exception->getLineWithinComment() + $commentStart);

            $phpcsFile->addError($exception->getMessage(), $line, 'ErrorParsing');

            return null;
        }

        return $commentParser;
    }
}
