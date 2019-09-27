<?php

namespace Firestorm\Tests\MonCalamari\Domain\Model\Missile;

use Firestorm\MonCalamari\Domain\Model\Missile\MissileSensor;
use Firestorm\Tests\Shared\UnitTestCase;

class MissileSensorTest extends UnitTestCase
{
	private $wind;
	private $humidity;

	protected function setUp()
	{
		parent::setUp();
		$this->wind = $this->fake()->sentence(3);
		$this->humidity = (string)$this->fake()->randomDigit;
	}

	protected function tearDown()
	{
		parent::tearDown();
		$this->wind = null;
		$this->humidity = null;
	}

	public function test_it_can_be_compared()
	{
		$anotherWind = $this->fake()->sentence(3);
		$anotherHumidity = (string)$this->fake()->randomDigit;

		$first = MissileSensor::with($this->wind, $this->humidity);
		$second = MissileSensor::with($this->wind, $this->humidity);
		$third = MissileSensor::with($anotherWind, $anotherHumidity);

		$this->assertTrue($first->equals($second));
		$this->assertFalse($first->equals($third));
	}

    public function test_it_return_the_sensor_with_weather_data()
    {
		$sensor = MissileSensor::with($this->wind, $this->humidity);
		$dataExpected = [
			'wind' => $sensor->wind(),
			'humidity' => $sensor->humidity()
		];

        $this->assertIsArray($sensor->toArray());
        $this->assertSame($dataExpected, $sensor->toArray());
    }
}
