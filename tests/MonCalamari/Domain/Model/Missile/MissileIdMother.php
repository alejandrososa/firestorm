<?php

namespace Firestorm\Tests\MonCalamari\Domain\Model\Missile;

use Firestorm\MonCalamari\Domain\Model\Missile\MissileId;

final class MissileIdMother
{
	public static function create(string $id): MissileId
	{
		return MissileId::fromString($id);
	}

	public static function random(): MissileId
	{
		return self::create(\Ramsey\Uuid\Uuid::uuid4());
	}
}