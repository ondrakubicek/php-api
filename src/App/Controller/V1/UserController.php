<?php

namespace api\App\Controller\V1;

use api\App\Repository\UserRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UserController {

	public function __construct(private UserRepository $userRepository)
	{
	}

	public function login(
		ServerRequestInterface $request,
		ResponseInterface $response,
	): ResponseInterface
	{
		//nothing yet
		$response->getBody()->write("AHOJ");
		return $response;
	}

	public function register(
		ServerRequestInterface $request,
		ResponseInterface $response,
	): ResponseInterface
	{
		$params = (array)$request->getParsedBody();

		$email = $params['email'];
		$name = $params['name'];
		$password = $params['password'];

		//nothing yet
		if($email && $name && $password) {
			$this->userRepository->createUser($email,$name,$password);
			$response->getBody()->write(json_encode(["status"=>"success"]));
		} else {
			$response->getBody()->write(json_encode(["status"=>"missing param"]));
		}

		return $response;
	}
}
