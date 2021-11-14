<?php
use api\App\DI\Core;

return array_merge(
	(new Core())->getDefinitions()
);
