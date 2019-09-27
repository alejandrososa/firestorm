<?php

namespace Firestorm\Tests\MonCalamari\Domain\Model\Missile;

use Faker\Factory;
use Firestorm\MonCalamari\Domain\Model\Missile\MissileSensor;

final class MissileSensorMother
{
	public static function create(string $wind, string $humidity): MissileSensor
	{
		return MissileSensor::with($wind, $humidity);
	}

	public static function random(): MissileSensor
	{
		return self::create(self::faker()->sentence(3), (string)self::faker()->randomDigit);
	}

	private static function faker()
	{
		return Factory::create();
	}
}