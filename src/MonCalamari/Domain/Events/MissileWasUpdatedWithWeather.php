<?php

namespace Firestorm\MonCalamari\Domain\Events;

use Firestorm\MonCalamari\Domain\Model\Missile\MissileId;
use Firestorm\MonCalamari\Domain\Model\Missile\MissileSensor;
use Prooph\EventSourcing\AggregateChanged;

class MissileWasUpdatedWithWeather extends AggregateChanged
{
    private $id;
    private $sensor;

    public static function with(MissileId $id, MissileSensor $sensor): self
    {
        $event = self::occur($id->toString(), [
            'sensor' => $sensor,
        ]);

        $event->sensor = $sensor;
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

    public function sensor(): MissileSensor
    {
        if (null === $this->sensor) {
            $this->sensor = MissileSensor::with(
                $this->payload['sensor']['wind'],
                $this->payload['sensor']['humidity']
            );
        }

        return $this->sensor;
    }
}