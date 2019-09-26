<?php

namespace Firestorm\MonCalamari\Application\Transformer;

use Firestorm\MonCalamari\Domain\Model\Missile\ProtonTorpedoMissile;

class MissileArrayTransformer implements TransformableInterface
{
	private $missile;

	public function write($data): TransformableInterface
	{
		$this->missile = $data;
		return $this;
	}

	public function read()
	{
		if (!$this->missile instanceof ProtonTorpedoMissile) {
			return [];
		}

		return [
			'area' => $this->missile->area()->toFloat(),
			'weather' => $this->missile->sensor() ? $this->missile->sensor()->toArray() : [],
		];
	}
}