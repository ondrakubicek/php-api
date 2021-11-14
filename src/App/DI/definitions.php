<?php

return array_merge(
	(new \api\App\DI\Core())->getDefinitions(),
	(new \api\App\DI\Services())->getDefinitions(),
	(new \api\App\DI\Repositories())->getDefinitions()
);
