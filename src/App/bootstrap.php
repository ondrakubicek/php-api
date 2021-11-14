<?php

use api\App\Controller\V1\UserController as UserController;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use \DI\Bridge\Slim\Bridge as SlimBridge;
use Slim\Routing\RouteCollectorProxy;

require __DIR__ . '/../vendor/autoload.php';

const API_VERSION = "/v1";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__."/../" );
$dotenv->load();


const DEFINITIONS_ROUTE = __DIR__ . '/DI/definitions.php';

$containerBuilder = new \DI\ContainerBuilder();
$containerBuilder->addDefinitions(DEFINITIONS_ROUTE);
$container = $containerBuilder->build();

$app = SlimBridge::create();

$app->group(API_VERSION, function (RouteCollectorProxy $group) {
	$group->group('/user', function (RouteCollectorProxy $group) {
		$group->post('/login' , [UserController::class, 'login']);
	});
});


$app->run();

return $container;
