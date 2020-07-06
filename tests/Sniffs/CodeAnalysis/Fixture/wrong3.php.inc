<?php

class MySessionStorage
{
    public $name = 'mySessionStorage';

    public function __construct()
    {
        $this->driver = new NativeSessionStorage();
    }

    public function start()
    {
        $this->driver->getInternal()->start();
    }
}
