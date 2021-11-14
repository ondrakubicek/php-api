<?php

namespace api\App\DI;

use api\App\Database;
use function DI\create;

class Core implements IDefinitions
{

	public function getDefinitions(): array
	{
		return [
			Database::class => create(Database::class),
		];
	}
}
