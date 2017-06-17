<?php

class NativeSessionStorage
{
    public function getInternal()
    {
        return new PHPSessionStorage();
    }
}

class PHPSessionStorage
{
    public function start()
    {
        session_start();

        return $this;
    }
}

$user = new User();

$user->sessionStorage->start();
