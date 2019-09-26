<?php

namespace Firestorm\MonCalamari\Infrastructure\Persistence;

use Firestorm\MonCalamari\Domain\Model\Missile\MissileId;
use Firestorm\MonCalamari\Domain\Model\Missile\MissileRepository;
use Firestorm\MonCalamari\Domain\Model\Missile\ProtonTorpedoMissile;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class RedisMissileRepository implements MissileRepository
{
    /**
     * @var AdapterInterface
     */
    private $cache;

    public function __construct(AdapterInterface $cache)
    {
        $this->cache = $cache;
    }

    public function save(ProtonTorpedoMissile $missile): void
    {
		$key = $missile->id()->toString();
        $item = $this->cache->getItem($key);
        $item->set(serialize($missile));
        $this->cache->save($item);
    }

    public function get(MissileId $missileId): ?ProtonTorpedoMissile
    {
        $item = $this->cache->getItem($missileId->toString());

        if(!$item->isHit()){
        	return null;
		}

		return unserialize($item->get());
    }
}