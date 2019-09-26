<?php

namespace Firestorm\Tests\MonCalamari\Domain\Model\Missile;

use Firestorm\MonCalamari\Domain\Model\Missile\MissileArea;

final class MissileAreaMother
{
	public static function create(int $precision): MissileArea
	{
		return MissileArea::fromInt($precision);
	}

	public static function random(): MissileArea
	{
		return self::create(mt_rand(MissileArea::MIN_ACCURACY, MissileArea::MAX_ACCURACY));
	}
}