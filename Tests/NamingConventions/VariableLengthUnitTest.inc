<?php

class Test
{
    public $testing = 1;

    public $te = 0;

    public function __construct($t)
    {
        $this->te = $t;
    }

    public function testing()
    {
        $red = 0;
        $green = 1;
        $bl = 2;

        for ($i = 0; $i < range(0, 9); $i++) {
            echo $i;
        }
    }
}
