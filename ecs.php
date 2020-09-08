<?php

declare(strict_types=1);

use PHP_CodeSniffer\Standards\Generic\Sniffs\Metrics\CyclomaticComplexitySniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Metrics\NestingLevelSniff;
use PhpCsFixer\Fixer\ControlStructure\YodaStyleFixer;
use PhpCsFixer\Fixer\Operator\NewWithBracesFixer;
use PhpCsFixer\Fixer\Operator\UnaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\PhpTag\BlankLineAfterOpeningTagFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocAlignFixer;
use SlevomatCodingStandard\Sniffs\Classes\UnusedPrivateElementsSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\AssignmentInConditionSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\DisallowYodaComparisonSniff;
use SlevomatCodingStandard\Sniffs\Exceptions\ReferenceThrowableOnlySniff;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(__DIR__ . '/config/object-calisthenics.php');

    $services = $containerConfigurator->services();

    $services->set(YodaStyleFixer::class)
        ->call('configure', [['equal' => false, 'identical' => false, 'less_and_greater' => false]]);

    $services->set(CyclomaticComplexitySniff::class)
        ->property('absoluteComplexity', 4);

    $services->set(NestingLevelSniff::class)
        ->property('absoluteNestingLevel', 2);

    $services->set(UnusedPrivateElementsSniff::class);
    $services->set(ReferenceThrowableOnlySniff::class);

    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, [__DIR__ . '/src', __DIR__ . '/tests']);
    $parameters->set(Option::SETS, [
        SetList::SYMFONY,
        SetList::PHP_70,
        SetList::PHP_71,
        SetList::PSR_12,
        SetList::COMMON,
        SetList::SYMPLIFY,
    ]);

    $parameters->set(Option::SKIP, [
        AssignmentInConditionSniff::class . '.FoundInWhileCondition' => null,
        BlankLineAfterOpeningTagFixer::class => null,
        NewWithBracesFixer::class => null,
        PhpdocAlignFixer::class => null,
        DisallowYodaComparisonSniff::class => null,
        UnaryOperatorSpacesFixer::class => null,
    ]);
};
