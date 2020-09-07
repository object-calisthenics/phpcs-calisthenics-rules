<?php

declare(strict_types=1);

use ObjectCalisthenics\Sniffs\Classes\ForbiddenPublicPropertySniff;
use ObjectCalisthenics\Sniffs\CodeAnalysis\OneObjectOperatorPerLineSniff;
use ObjectCalisthenics\Sniffs\ControlStructures\NoElseSniff;
use ObjectCalisthenics\Sniffs\Files\ClassTraitAndInterfaceLengthSniff;
use ObjectCalisthenics\Sniffs\Files\FunctionLengthSniff;
use ObjectCalisthenics\Sniffs\Metrics\MaxNestingLevelSniff;
use ObjectCalisthenics\Sniffs\Metrics\MethodPerClassLimitSniff;
use ObjectCalisthenics\Sniffs\Metrics\PropertyPerClassLimitSniff;
use ObjectCalisthenics\Sniffs\NamingConventions\ElementNameMinimalLengthSniff;
use ObjectCalisthenics\Sniffs\NamingConventions\NoSetterSniff;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(MaxNestingLevelSniff::class)
        ->property('maxNestingLevel', 2);

    $services->set(NoElseSniff::class);

    $services->set(OneObjectOperatorPerLineSniff::class)
        ->property('variablesHoldingAFluentInterface', ['$queryBuilder', '$containerBuilder'])
        ->property('methodsStartingAFluentInterface', ['createQueryBuilder'])
        ->property('methodsEndingAFluentInterface', ['execute', 'getQuery']);

    $services->set(ElementNameMinimalLengthSniff::class)
        ->property('minLength', 3)
        ->property('allowedShortNames', ['i', 'id', 'to', 'up']);

    $services->set(ClassTraitAndInterfaceLengthSniff::class)
        ->property('maxLength', 200);

    $services->set(FunctionLengthSniff::class)
        ->property('maxLength', 20);

    $services->set(PropertyPerClassLimitSniff::class)
        ->property('maxCount', 10);

    $services->set(MethodPerClassLimitSniff::class)
        ->property('maxCount', 10);

    $services->set(ForbiddenPublicPropertySniff::class);

    $services->set(NoSetterSniff::class);
};
