<?php

require __DIR__ . '/../vendor/autoload.php';

const API_VERSION = "/v1";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();


$app = (new \api\App\App())->getApp();

$app->run();

