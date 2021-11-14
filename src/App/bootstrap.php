<?php

use api\App\Controller\V1\UserController as UserController;
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

$app = SlimBridge::create($container);

$app->add(new Tuupola\Middleware\JwtAuthentication([
	"secret" => $_ENV['JWT_TOKEN'],
	"ignore" => ["/v1/user/login"],
	"ignore" => ["/v1/user/register"],
]));

$app->group(API_VERSION, function (RouteCollectorProxy $group) {
	$group->group('/user', function (RouteCollectorProxy $group) {
		$group->post('/login' , [UserController::class, 'login']);
		$group->post('/register' , [UserController::class, 'register']);
	});
});


$app->run();

return $container;
