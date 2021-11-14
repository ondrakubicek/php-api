<?php

namespace api\App\DI;

use api\App\Service\AuthService;
use function DI\autowire;

class Services implements IDefinitions
{

	public function getDefinitions(): array
	{
		return [
			AuthService::class => autowire(AuthService::class),
		];
	}
}
