<?php

namespace Firestorm\Tests\MonCalamari\Application\Query;

use Firestorm\MonCalamari\Application\Query\GetAreaById;
use Firestorm\MonCalamari\Domain\Model\Missile\MissileId;
use Firestorm\Tests\MonCalamari\Domain\Model\Missile\MissileIdMother;

final class GetAreaByIdMother
{
	public static function create(MissileId $id): GetAreaById
	{
		return new GetAreaById($id->toString());
	}

	public static function random(): GetAreaById
	{
		return self::create(MissileIdMother::random());
	}
}