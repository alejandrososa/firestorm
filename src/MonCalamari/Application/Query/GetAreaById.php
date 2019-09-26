<?php

namespace Firestorm\MonCalamari\Application\Query;

class GetAreaById
{
	/**
	 * @var string
	 */
	private $id;

	public function __construct(string $id)
	{
		$this->id = $id;
	}

	/**
	 * @return string
	 */
	public function id(): string
	{
		return $this->id;
	}
}