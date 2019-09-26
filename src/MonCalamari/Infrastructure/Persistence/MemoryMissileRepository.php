<?php

namespace Firestorm\MonCalamari\Infrastructure\Persistence;

use Firestorm\MonCalamari\Domain\Model\Missile\MissileId;
use Firestorm\MonCalamari\Domain\Model\Missile\MissileRepository;
use Firestorm\MonCalamari\Domain\Model\Missile\ProtonTorpedoMissile;

class MemoryMissileRepository implements MissileRepository
{

	public function save(ProtonTorpedoMissile $missile): void
	{
		echo '<pre>'; print_r([__CLASS__, __METHOD__, __LINE__, $missile]); echo '</pre>'; die();
	}

	public function get(MissileId $missileId): ?ProtonTorpedoMissile
	{
		return null;
	}
}