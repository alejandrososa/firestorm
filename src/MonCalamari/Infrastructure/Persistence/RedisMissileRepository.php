<?php

namespace Firestorm\MonCalamari\Infrastructure\Persistence;

use Firestorm\MonCalamari\Domain\Model\Missile\MissileId;
use Firestorm\MonCalamari\Domain\Model\Missile\MissileRepository;
use Firestorm\MonCalamari\Domain\Model\Missile\ProtonTorpedoMissile;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Serializer\SerializerInterface;

class RedisMissileRepository implements MissileRepository
{
    /**
     * @var AdapterInterface
     */
    private $cache;
    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(AdapterInterface $cache, SerializerInterface $serializer)
    {
        $this->cache = $cache;
        $this->serializer = $serializer;
    }

    public function save(ProtonTorpedoMissile $missile): void
    {
        $key = $missile->id()->toString();
        $item = $this->cache->getItem($key);
        $item->set($this->serializer->serialize($missile, 'json'));
        $this->cache->save($item);
    }

    public function get(MissileId $missileId): ?ProtonTorpedoMissile
    {
        $item = $this->cache->getItem($missileId->toString());
        $missile = $this->serializer->deserialize($item, ProtonTorpedoMissile::class, 'json');

        return $missile;
    }
}