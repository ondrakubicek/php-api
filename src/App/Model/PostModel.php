<?php

namespace api\App\Model;

class PostModel
{
	public function __construct(
		private int    $id,
		private string $title,
		private string $text,
		private int    $userId,
		private int    $timestamp,
	)
	{
	}

	public function getId(): int
	{
		return $this->id;
	}

	public function getTitle(): string
	{
		return $this->title;
	}

	public function getText(): string
	{
		return $this->text;
	}

	public function getUserId(): int
	{
		return $this->userId;
	}

	public function getTimestamp(): int
	{
		return $this->timestamp;
	}
}
