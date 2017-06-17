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

    public function getSessionStorageName()
    {
        return $this->sessionStorage->name;
    }
}
