<?php

namespace api\App\DI;

use api\App\Repository\UserRepository;
use function DI\autowire;

class Repositories implements IDefinitions
{

	public function getDefinitions(): array
	{
		return [
			UserRepository::class => autowire(UserRepository::class),
		];
	}
}
