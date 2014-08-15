<?php

class ObjectOriented
{
    public function test()
    {
        $a = array();

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

function structural()
{
    $a = array();

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

?>
