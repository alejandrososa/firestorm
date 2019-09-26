<?php

namespace Firestorm\Tests\MonCalamari\Application\Command;

use Firestorm\MonCalamari\Application\Command\CalculateArea;
use Firestorm\MonCalamari\Application\Command\CalculateAreaHandler;
use Firestorm\MonCalamari\Application\Exception\CalculatedAreaAlreadyExists;
use Firestorm\Tests\MonCalamari\Domain\Model\Missile\MissileMother;
use Firestorm\Tests\MonCalamari\MissileUnitTestCase;

class CalculateAreaHandlerTest extends MissileUnitTestCase
{
	private $handler;

	protected function setUp()
	{
		$this->handler = new CalculateAreaHandler(
			$this->repository()
		);
	}

	protected function tearDown(): void
	{
		parent::tearDown();
		$this->handler = null;
	}

	private function getCalculateArea(): CalculateArea
	{
		return CalculateAreaMother::random();
	}

	public function test_validate_that_the_command_exists()
	{
		$this->assertInstanceOf(CalculateArea::class, $this->getCalculateArea());
	}

	public function test_validate_that_an_exception_returns_if_the_calculated_area_already_exist()
	{
		$this->expectException(CalculatedAreaAlreadyExists::class);

		$command = $this->getCalculateArea();

        $missile = MissileMother::randomWithId($command->id());
		$this->shouldGetMissileById($command->id(), $missile);

		$this->handler->__invoke($command);
	}

	public function test_you_can_save_a_calculated_area()
	{
		$command = $this->getCalculateArea();

		$this->shouldGetMissileById($command->id(), null);
        $this->shouldSaveMissileWithAreaCalculated();

        $this->handler->__invoke($command);
	}
}
