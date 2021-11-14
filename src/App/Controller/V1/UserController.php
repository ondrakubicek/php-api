<?php

namespace api\App\Controller\V1;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UserController {

	public function login(
		ServerRequestInterface $request,
		ResponseInterface $response,
	): ResponseInterface
	{
		//nothing yet
		return $response;
	}
}
