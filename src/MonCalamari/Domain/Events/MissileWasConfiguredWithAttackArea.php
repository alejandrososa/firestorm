<?php

namespace Firestorm\MonCalamari\Domain\Events;

use Firestorm\MonCalamari\Domain\Model\Missile\MissileArea;
use Firestorm\MonCalamari\Domain\Model\Missile\MissileId;
use Prooph\EventSourcing\AggregateChanged;

class MissileWasConfiguredWithAttackArea extends AggregateChanged
{
    private $id;
    private $area;

    public static function with(MissileId $id, MissileArea $area): self
    {
        $event = self::occur($id->toString(), [
            'area' => $area,
        ]);

        $event->area = $area;
        $event->id = $id;

        return $event;
    }

    public function id(): MissileId
    {
        if (null === $this->id) {
            $this->id = MissileId::fromString($this->aggregateId());
        }

        return $this->id;
    }

    public function area(): MissileArea
    {
        if (null === $this->area) {
            $this->area = MissileArea::fromInt($this->payload['area']);
        }

        return $this->area;
    }
}