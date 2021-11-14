<?php

namespace api\App\Controller\V1;

use api\App\Exceptions\AlreadyExistsException;
use api\App\Exceptions\NotFoundException;
use api\App\Repository\UserRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use \Firebase\JWT\JWT;

class UserController {

	public function __construct(private UserRepository $userRepository)
	{
	}

	public function login(
		ServerRequestInterface $request,
		ResponseInterface $response,
	): ResponseInterface
	{
		$params = (array)$request->getParsedBody();

		$email = $params['email'];
		$password = $params['password'];

		try {
			$user = $this->userRepository->getUserByEmailAndPassword($email, $password);
			$payload = array(
				'iss' => $request->getServerParams()['SERVER_NAME'],
				'exp' => time()+600, 'uId' => $user->getId()
			);
			try{
				$jwt = JWT::encode($payload, $_ENV['JWT_TOKEN_SECRET'],'HS256');
				$res = ["status"=>"succes","token"=>$jwt];

			}catch (UnexpectedValueException $exception) {
				$res = ["status" => "failed", "message" => $exception->getMessage()];
			}
		} catch (NotFoundException $exception){
			$res = ["status" => "failed", "message" => $exception->getMessage()];
		}

		$response->getBody()->write(json_encode($res));
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

		if($email && $name && $password) {
			try {
				$this->userRepository->createUser($email, $name, $password);
				$res = ["status"=>"success"];
			} catch (AlreadyExistsException $exception){
				$res = ["status" => "failed", "message" => $exception->getMessage()];
			}
			$response->getBody()->write(json_encode($res));
		} else {
			$response->getBody()->write(json_encode(["status"=>"failed", "message" => "missing required param"]));
		}

		return $response;
	}
}
