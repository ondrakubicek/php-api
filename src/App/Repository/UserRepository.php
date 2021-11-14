<?php

namespace api\App\Repository;

use api\App\Exceptions\AlreadyExistsException;
use api\App\Exceptions\NotFoundException;
use api\App\Model\UserModel;

class UserRepository extends BaseRepository
{


	public function createUser(string $email, string $name, string $password)
	{

		$password_hash = password_hash($password, PASSWORD_BCRYPT);
		try {
			$user = $this->getUserByEmail($email);
			if ($user) {
				throw new AlreadyExistsException("User already exists");
			}
		} catch (NotFoundException $exception) {
			$connection = $this->database->connect();
			$query = 'INSERT INTO User
				SET name = :name,
					email = :email,
					password = :password';

			$statement = $connection->prepare($query);
			$statement->execute([
				':name' => $name,
				':email' => $email,
				':password' => $password_hash,
			]);
		}

	}

	/**
	 * @throws NotFoundException
	 */
	public function getUserByEmailAndPassword(string $email, string $password): UserModel
	{
		$query = 'SELECT id, name, email, password FROM User WHERE email = :email';
		$statement = $this->database->connect()->prepare($query);
		$statement->execute([
			':email' => $email
		]);
		foreach ($statement->fetchAll() as $userFetch) {
			if (password_verify($password, $userFetch["password"])) {
				return new UserModel($userFetch["id"], $userFetch["name"], $userFetch["email"]);
			}
		}
		throw new NotFoundException("user not found");
	}


	/**
	 * @throws NotFoundException
	 */
	public function getUserByEmail(string $email): UserModel
	{
		$query = 'SELECT id, name, email FROM User WHERE email = :email';
		$statement = $this->database->connect()->prepare($query);
		$statement->execute([
			':email' => $email
		]);
		$dbUser = $statement->fetchObject();
		if ($dbUser) {
			return new UserModel($dbUser->id, $dbUser->name, $dbUser->email);
		} else {
			throw new NotFoundException("user not found");
		}
	}
}
