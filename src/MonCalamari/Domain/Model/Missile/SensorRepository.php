<?php

namespace Firestorm\MonCalamari\Domain\Model\Missile;

interface SensorRepository
{
	public function save(MissileId $missileId, MissileSensor $sensor): void;
	public function get(MissileId $missileId): ?MissileSensor;
}