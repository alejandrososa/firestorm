<?php

namespace Firestorm\MonCalamari\Application\Command;

class CalculateArea
{
	/**
	 * @var string
	 */
	private $id;
	/**
	 * @var int
	 */
	private $precision;

	public function __construct(string $id, int $precision)
	{
		$this->id = $id;
		$this->precision = $precision;
	}

	/**
	 * @return string
	 */
	public function id(): string
	{
		return $this->id;
	}

	/**
	 * @return int
	 */
	public function precision(): int
	{
		return $this->precision;
	}
}