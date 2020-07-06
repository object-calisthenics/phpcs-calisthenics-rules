<?php

declare(strict_types=1);

namespace ObjectCalisthenics\Helper;

use ObjectCalisthenics\ValueObject\TokenKey;

final class FluentInterfaceDetector
{
    /**
     * @param string[] $methodsEndingAFluentInterface
     * @param string[] $methodsStartingAFluentInterface
     * @param string[] $variablesHoldingAFluentInterface
     * @param mixed[] $callerTokens
     */
    public function isInFluentInterfaceMode(
        array $methodsEndingAFluentInterface,
        array $methodsStartingAFluentInterface,
        string $variableName,
        array $variablesHoldingAFluentInterface,
        array $callerTokens
    ): bool {
        $lastEndPoint = $this->computeLastCallOfAnyFrom($methodsEndingAFluentInterface, $callerTokens);
        $lastStartPoint = $this->computeLastCallOfAnyFrom($methodsStartingAFluentInterface, $callerTokens);

        if (in_array($variableName, $variablesHoldingAFluentInterface, true)) {
            $lastStartPoint = max($lastStartPoint, -1);
        }

        return $lastStartPoint > -2
            && $lastStartPoint > $lastEndPoint;
    }

    /**
     * @param string[] $methods
     * @param mixed[] $callerTokens
     *
     * @return int The last position of the method calls within the callerTokens
     *             or -2 if none of the methods has been called
     */
    private function computeLastCallOfAnyFrom(array $methods, array $callerTokens): int
    {
        $calls = array_filter(
            $callerTokens,
            fn (array $token): bool => in_array($token[TokenKey::TOKEN][TokenKey::CONTENT], $methods, true)
        );

        if (count($calls) > 0) {
            return (int) array_search(end($calls), $callerTokens, true);
        }

        return -2;
    }
}
