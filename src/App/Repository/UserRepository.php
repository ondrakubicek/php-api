<?php

namespace api\App\Repository;

use api\App\Database;

class UserRepository {

	public function __construct(
		private Database $database
	)
	{
	}

	public function createUser(string $name, string $email,string $password) {
		$connection = $this->database->connect();

		$query = "INSERT INTO User
			SET name = :name,
				email = :email,
				password = :password";

		$password_hash = password_hash($password, PASSWORD_BCRYPT);


		$statement = $connection->prepare($query);
		$statement->execute([
			':name'=> $name,
			':email' => $email,
			':password' => $password_hash,
		]);
	}
}
