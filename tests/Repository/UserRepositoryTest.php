<?php
namespace api\Tests\Repository;

use api\App\Database;
use api\App\Exceptions\NotFoundException;
use api\App\Repository\UserRepository;

class UserRepositoryTest extends \PHPUnit\Framework\TestCase {

	private Database $databaseMock;
	private \PDO $dbConnectionMock;
	private \PDOStatement $PDOStatementMock;
	private UserRepository $userRepository;

	public function setUp(): void
	{
		$this->dbConnectionMock = $this->getMockBuilder(\PDO::class)
			->disableOriginalConstructor()
			->onlyMethods(["prepare"])
			->getMock();

		$this->PDOStatementMock = $this->getMockBuilder(\PDOStatement::class)
			->disableOriginalConstructor()
			->onlyMethods(["execute","fetchObject","fetchAll"])
			->getMock();


		$this->databaseMock = $this->getMockBuilder(Database::class)
			->disableOriginalConstructor()
			->onlyMethods(["connect"])
			->getMock();

		$this->dbConnectionMock->method("prepare")->willReturn($this->PDOStatementMock);
		$this->databaseMock->method("connect")->willReturn($this->dbConnectionMock);

		$this->userRepository = new UserRepository($this->databaseMock);
	}

	public function testGetUserByEmail() {
		$testData = ["id"=>1, "name"=>"tester", "email" => "test@test.com"];
		$this->PDOStatementMock->method("fetchObject")->willReturn((object)$testData);
		$user = $this->userRepository->getUserByEmail($testData["email"]);
		$this->assertSame($testData["email"], $user->getEmail());
	}


	public function testGetUserByEmailNotFound() {
		$this->PDOStatementMock->method("fetchObject")->willReturn(null);
		$this->expectException(NotFoundException::class);
		$user = $this->userRepository->getUserByEmail("test");
	}
}
