<?php

namespace api\App\Controller\V1;

use api\App\Exceptions\AlreadyExistsException;
use api\App\Exceptions\NotFoundException;
use api\App\Repository\UserRepository;
use api\App\Service\AuthService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UserController
{

	public function __construct(
		private UserRepository $userRepository,
		private AuthService    $authService,
	)
	{
	}

	public function login(
		ServerRequestInterface $request,
		ResponseInterface      $response,
	): ResponseInterface
	{
		$params = (array)$request->getParsedBody();

		$email = $params['email'];
		$password = $params['password'];

		try {
			$user = $this->userRepository->getUserByEmailAndPassword($email, $password);
			$jwt = $this->authService->createJwt($request->getServerParams()['SERVER_NAME'], $user->getId());
			$res = ["status" => "success", "token" => $jwt];
		} catch (NotFoundException $exception) {
			$res = ["status" => "failed", "message" => $exception->getMessage()];
		}

		$response->getBody()->write(json_encode($res));
		return $response;
	}

	public function register(
		ServerRequestInterface $request,
		ResponseInterface      $response,
	): ResponseInterface
	{
		$params = (array)$request->getParsedBody();

		$email = $params['email'];
		$name = $params['name'];
		$password = $params['password'];

		if ($email && $name && $password) {
			try {
				$this->userRepository->createUser($email, $name, $password);
				$res = ["status" => "success"];
			} catch (AlreadyExistsException $exception) {
				$res = ["status" => "failed", "message" => $exception->getMessage()];
			}
			$response->getBody()->write(json_encode($res));
		} else {
			$response->getBody()->write(json_encode(["status" => "failed", "message" => "missing required param"]));
		}

		return $response;
	}
}
