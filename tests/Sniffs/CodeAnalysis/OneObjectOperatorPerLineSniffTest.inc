<?php

class User
{
    public $sessionStorage;

    public function __construct()
    {
        $this->sessionStorage = new MySessionStorage();

        $this->getSessionStorage()->start();
        $this->create();
    }

    public function create()
    {
        $this->sessionStorage->start();
        $this->sessionStorage->start()->start();
        $this->getSessionStorage()->start()->start();
    }

    private function getSessionStorage()
    {
        return $this->sessionStorage;
    }
}

class MySessionStorage
{
    public function __construct()
    {
        $this->driver = new NativeSessionStorage();
    }

    public function start()
    {
        $this->driver->getInternal()->start();
    }
}

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
