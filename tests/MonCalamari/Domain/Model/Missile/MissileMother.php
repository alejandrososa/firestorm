<?php

namespace Firestorm\Tests\MonCalamari\Domain\Model\Missile;

use Firestorm\MonCalamari\Domain\Model\Missile\MissileArea;
use Firestorm\MonCalamari\Domain\Model\Missile\MissileId;
use Firestorm\MonCalamari\Domain\Model\Missile\ProtonTorpedoMissile;

final class MissileMother
{
	public static function create(MissileId $id, MissileArea $precision): ProtonTorpedoMissile
	{
		return ProtonTorpedoMissile::configureAttackArea($id, $precision);
	}

	public static function random(): ProtonTorpedoMissile
	{
		return self::create(MissileIdMother::random(), MissileAreaMother::random());
	}

	public static function randomWithId(string $id): ProtonTorpedoMissile
	{
		return self::create(MissileIdMother::create($id), MissileAreaMother::random());
	}

	public static function randomWithIdAndArea(string $id, float $precision): ProtonTorpedoMissile
	{
		return self::create(MissileIdMother::create($id), MissileAreaMother::create($precision));
	}
}