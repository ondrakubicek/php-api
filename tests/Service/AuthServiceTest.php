<?php
namespace api\Tests\Service;

class AuthServiceTest extends \PHPUnit\Framework\TestCase {

	public function setUp(): void
	{
		$_ENV = ['JWT_TOKEN_SECRET' => 'testsecret'];
	}

	public function testGetUserIdFromJwt() {

		$authService = new \api\App\Service\AuthService();
		$userId = 5;
		$token = $authService->createJwt("TEST",5);
		$authorizationHeader = sprintf("Bearer %s", $token);
		$this->assertEquals($userId, $authService->getUserIdFromJwt($authorizationHeader));
	}
}
