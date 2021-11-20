<?php

namespace api\App\Controller\V1;

use api\App\Repository\PostRepository;
use api\App\Service\AuthService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PostController
{


	public function __construct(
		private PostRepository $postRepository,
		private AuthService    $authService,
	)
	{
	}

	public function create(
		ServerRequestInterface $request,
		ResponseInterface      $response,
	): ResponseInterface
	{
		$params = (array)$request->getParsedBody();
		$userId = $this->authService->getUserIdFromJwt($request->getHeader("Authorization")[0]);

		$title = $params['title'];
		$text = $params['text'];

		$this->postRepository->createPost(
			$title,
			$text,
			$userId,
		);

		$res = ["status" => "success"];
		$response->getBody()->write(json_encode($res));

		return $response;
	}
}
