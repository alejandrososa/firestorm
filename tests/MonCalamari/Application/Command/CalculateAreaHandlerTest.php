<?php

namespace Firestorm\Tests\MonCalamari\Application\Command;

use Firestorm\MonCalamari\Application\Command\CalculateArea;
use Firestorm\MonCalamari\Application\Command\CalculateAreaHandler;
use Firestorm\MonCalamari\Application\Event\AttachWeatherToMissile;
use Firestorm\MonCalamari\Application\Exception\CalculatedAreaAlreadyExists;
use Firestorm\Tests\MonCalamari\Domain\Model\Missile\MissileMother;
use Firestorm\Tests\Shared\IntegrationTestCase;

class CalculateAreaHandlerTest extends IntegrationTestCase
{
	private $handler;

	protected function setUp()
	{
		$this->handler = new CalculateAreaHandler(
			$this->missileRepository(),
            $this->bus()
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
		$command = $this->getCalculateArea();

		$this->expectException(CalculatedAreaAlreadyExists::class);
		$this->shouldGetMissileById($command->id(), MissileMother::randomWithId($command->id()));

		$this->handler->__invoke($command);
	}

	public function test_you_can_save_a_calculated_area()
	{
		$command = $this->getCalculateArea();

		$this->shouldGetMissileById($command->id(), null);
        $this->shouldSaveMissileWithAreaCalculated();
        $this->shouldDispatch(new AttachWeatherToMissile($command->id()));

        $this->handler->__invoke($command);
	}
}
