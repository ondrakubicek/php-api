<?php

namespace api\App\Repository;

use api\App\Database;

abstract class BaseRepository
{

	public function __construct(
		protected Database $database
	)
	{
	}
}
