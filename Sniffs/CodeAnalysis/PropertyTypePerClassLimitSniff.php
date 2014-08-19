<?php

/**
 * Check for property type per class limit, part of "Use first class collections" OC rule.
 *
 * {@internal Barbara Liskov feels sick every time she looks at this class code.}
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
class ObjectCalisthenics_Sniffs_CodeAnalysis_PropertyTypePerClassLimitSniff extends PHP_CodeSniffer_Standards_AbstractVariableSniff
{
    /**
     * Property type list to check
     *
     * @var array
     */
    public $propertyTypeList = array('array');

    /**
     * Maximum amount of properties of a given type
     *
     * @var integer
     */
    public $maxCount = 1;

    /**
     * Absolute maximum amount of a property type
     *
     * @var integer
     */
    public $absoluteMaxCount = 1;

    /**
     * List of already declared properties
     *
     * @var array
     */
    private $propertyList = array();

    /**
     * Supported list of tokenizers supported by this sniff.
     *
     * @var array
     */
    public $supportedTokenizers = array('PHP');

    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param \PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param integer               $stackPtr  The position of the current token
     *                                         in the stack passed in $tokens.
     */
    protected function processMemberVar(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $this->addProperty($phpcsFile, $stackPtr);

        $lastProperty         = end($this->propertyList);
        $lookupPropertyType   = $lastProperty['data_type'];
        $filteredPropertyList = array_filter(
            $this->propertyList, 
            function ($property) use ($lookupPropertyType)
            {
                return ($property['data_type'] === $lookupPropertyType);
            }
        );
        $propertyTypeCount    = count($filteredPropertyList);

        switch (true) {
            case ($propertyTypeCount > $this->absoluteMaxCount):
                $message = 'Your class has multiple properties of "%s" type, must be less or equals than %d properties in totall';
                $error   = sprintf($message, $lookupPropertyType, $this->absoluteMaxCount);

                $phpcsFile->addError($error, $stackPtr, 'MultiPropertyOfType');

                break;

            case ($propertyTypeCount > $this->maxCount):
                $message = 'Your class has multiple properties of "%s" type, consider refactoring (must be less or equals than %d properties)';
                $warning = sprintf($message, $lookupPropertyTypeList, $this->maxCount);

                $phpcsFile->addWarning($warning, $stackPtr, 'MultiPropertyOfType');

                break;
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function processVariable(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        // We don't care about normal variables.
    }

    /**
     * {@inheritdoc}
     */
    protected function processVariableInString(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        // We don't care about normal variables.
    }

    /**
     * Add property to the list of declared properties.
     *
     * @param \PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param integer               $stackPtr  The position of the current token
     *                                         in the stack passed in $tokens.
     */
    private function addProperty(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens       = $phpcsFile->getTokens();
        $lastProperty = end($this->propertyList);

        // Clear property list of we switch classes 
        if ($lastProperty && $lastProperty['token']['conditions'] !== $tokens[$stackPtr]['conditions']) {
            $this->propertyList = array();
        }

        $comment = $this->processMemberComment($phpcsFile, $stackPtr);

        // If comment couldnt be properly parsed, error was already added.
        if ( ! $comment) {
            return;
        }

        $varDoc   = $comment->getVar();
        $dataType = $varDoc->getContent();

        array_push(
            $this->propertyList,
            array(
                'pointer'   => $stackPtr,
                'token'     => $tokens[$stackPtr],
                'data_type' => $dataType,
            )
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
