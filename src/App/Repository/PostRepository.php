<?php

namespace api\App\Repository;

class PostRepository extends BaseRepository
{

	public function createPost(
		string $title,
		string $text,
		int    $userId
	)
	{
		$connection = $this->database->connect();
		$query = 'INSERT INTO Posts
				SET title = :title,
					text = :text,
					userId = :userId,
					timestamp = :timestamp';

		$statement = $connection->prepare($query);
		$time = time();
		$statement->execute([
			':title' => $title,
			':text' => $text,
			':userId' => $userId,
			':timestamp' => $time,
		]);
	}


}
