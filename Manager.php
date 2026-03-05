<?php

abstract class Manager
{
    protected ?\PDO $database = null;

    public function __construct()
    {
        if ($this->database === null) {
            $this->database = new \PDO('mysql:host=127.0.0.1;dbname=contact_manager;charset=utf8', 'root', 'root');
        }
    }
}