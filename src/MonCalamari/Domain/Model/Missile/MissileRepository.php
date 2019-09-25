<?php

namespace Firestorm\MonCalamari\Domain\Model\Missile;

interface MissileRepository
{
	public function save(ProtonTorpedoMissile $missile): void;
	public function get(MissileId $categoryId): ?ProtonTorpedoMissile;
}