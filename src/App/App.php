<?php
namespace api\App;

use \DI\Bridge\Slim\Bridge as SlimBridge;
use api\App\Controller\V1\UserController as UserController;
use api\App\Controller\V1\PostController as PostController;
use Slim\Routing\RouteCollectorProxy;

class App
{
	const DEFINITIONS_ROUTE = __DIR__ . '/DI/definitions.php';

	private \Slim\App $app;

	public function __construct() {

		$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
		$dotenv->load();

		$containerBuilder = new \DI\ContainerBuilder();
		$containerBuilder->addDefinitions(self::DEFINITIONS_ROUTE);
		$container = $containerBuilder->build();

		$app = SlimBridge::create($container);

		$app->add(new \Tuupola\Middleware\JwtAuthentication([
			"secret" => $_ENV['JWT_TOKEN_SECRET'],
			"ignore" => ["/v1/user/login", "/v1/user/register"],
			"algorithm" => ["HS256"],
		]));

		$app->group(API_VERSION, function (RouteCollectorProxy $group) {
			$group->group('/user', function (RouteCollectorProxy $group) {
				$group->post('/login', [UserController::class, 'login']);
				$group->post('/register', [UserController::class, 'register']);
			});
			$group->group('/post', function (RouteCollectorProxy $group) {
				$group->post('/create', [PostController::class, 'create']);
			});
		});


		$this->app = $app;

		return $container;
	}

	public function getApp(): \Slim\App
	{
		return $this->app;
	}
}
