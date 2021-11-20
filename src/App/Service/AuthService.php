<?php

namespace api\App\Service;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthService
{

	const USER_ID = 'uId';
	const BEARER_REGEX = '/Bearer\s+(.*)$/i';

	public function createJwt(string $serverName, int $userId): string
	{
		$payload = array(
			'iss' => $serverName,
			'exp' => time() + 600,
			self::USER_ID => $userId
		);
		return JWT::encode($payload, $_ENV['JWT_TOKEN_SECRET'], 'HS256');
	}

	public function getUserIdFromJwt(String $authorizationHeader): int
	{
		$tokenBearer = $authorizationHeader;

		$matches = [];
		preg_match(self::BEARER_REGEX, $tokenBearer, $matches);
		$decoded = $this->decodeJwt($matches[1]);
		return $decoded[self::USER_ID];
	}

	private function decodeJwt(string $jwt): array
	{
		return (array)JWT::decode($jwt, new Key($_ENV['JWT_TOKEN_SECRET'], 'HS256'));
	}
}
