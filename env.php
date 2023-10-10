<?php
    require_once realpath(__DIR__ . "/vendor/autoload.php");
    use Dotenv\Dotenv;

    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    function env(string $name) {
        global $dotenv;
        return $dotenv->load()[$name];
    }