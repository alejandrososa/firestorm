<?php

namespace Firestorm\MonCalamari\Infrastructure\Persistence;

use Firestorm\MonCalamari\Domain\Model\Missile\MissileId;
use Firestorm\MonCalamari\Domain\Model\Missile\MissileSensor;
use Firestorm\MonCalamari\Domain\Model\Missile\SensorRepository;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class RedisSensorRepository implements SensorRepository
{
    private const PREFIX_KEY = 'sensor-';

    /**
     * @var AdapterInterface
     */
    private $cache;

    public function __construct(AdapterInterface $cache)
    {
        $this->cache = $cache;
    }

    public function save(MissileId $missileId, MissileSensor $sensor): void
    {
        $key = $missileId->toString();
        $item = $this->cache->getItem(self::PREFIX_KEY.$key);
        $item->set(serialize($sensor));
        $this->cache->save($item);
    }

    public function get(MissileId $missileId): ?MissileSensor
    {
        $item = $this->cache->getItem(self::PREFIX_KEY.$missileId->toString());

        if(!$item->isHit()){
            return null;
        }

        return unserialize($item->get());
    }
}