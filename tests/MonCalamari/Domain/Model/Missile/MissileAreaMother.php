<?php

namespace Firestorm\Tests\MonCalamari\Domain\Model\Missile;

use Firestorm\MonCalamari\Domain\Model\Missile\MissileArea;
use Firestorm\MonCalamari\Domain\Model\Missile\MissileId;

final class MissileAreaMother
{
	public static function create(int $presision): MissileArea
	{
		return MissileArea::fromInt($presision);
	}

	public static function random(): MissileArea
	{
		return self::create(random_int(MissileArea::MIN_ACCURACY, MissileArea::MAX_ACCURACY));
	}
}