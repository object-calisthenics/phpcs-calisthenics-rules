<?php

class ObjectOriented
{
    public function test()
    {
        $a = [];

        if ($a === 2) {
            echo 'Test';
        }

        foreach ($a as $v) {
            if ($v !== null) {
                return $v;
            }
        }

        return null;
    }
}

function nestingFive()
{
    if ($condition) {
        echo 'hi';

        switch ($condition) {
            case '1':
                if ($condition === '1') {
                    if ($cond) {
                        echo 'hi';
                    }
                }

                break;
        }
    }
}

function structural()
{
    $a = [];

    if ($a === 2) {
        echo 'Test';
    }

    foreach ($a as $v) {
        if ($v !== null) {
            return $v;
        }
    }

    return null;
}

function usingLambdaTwoLevels()
{
    $foo = function ()
    {
        if ($condition) {
            if ($cond) {
                echo 'hi';
            }
        }
    };

    $foo();
}

function usingLambdaOneLevel()
{
    $bar = function ()
    {
        switch ($condition) {
            case '1':
                echo 'hi';

                break;
        }
    };

    $bar();
}


function usingMultipleSwitchInsideLambda()
{
    $bar = function ()
    {
        switch ($condition) {
            case '1':
                switch ($cond) {
                    case '2':
                        echo 'hi';

                        break;
                }

                // Intentionally left break out to check scope_closer fix
        }
    };

    $bar();
}

function usingLambdaDefault()
{
    $bar = function ()
    {
        switch ($condition) {
            case '1':
                echo 'hi';

                break;
            default:
                echo 'hi';

                break;
        }
    };

    $bar();
}

?>
