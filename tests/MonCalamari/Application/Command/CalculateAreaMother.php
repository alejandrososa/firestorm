<?php

namespace Firestorm\Tests\MonCalamari\Application\Command;

use Firestorm\MonCalamari\Application\Command\CalculateArea;
use Firestorm\MonCalamari\Domain\Model\Missile\MissileArea;
use Firestorm\MonCalamari\Domain\Model\Missile\MissileId;
use Firestorm\Tests\MonCalamari\Domain\Model\Missile\MissileAreaMother;
use Firestorm\Tests\MonCalamari\Domain\Model\Missile\MissileIdMother;

final class CalculateAreaMother
{
	public static function create(MissileId $id, MissileArea $area): CalculateArea
	{
		return new CalculateArea($id->toString(), $area->toFloat());
	}

	public static function random(): CalculateArea
	{
		return self::create(MissileIdMother::random(), MissileAreaMother::random());
	}
}