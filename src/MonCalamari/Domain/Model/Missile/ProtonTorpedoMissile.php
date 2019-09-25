<?php

namespace Firestorm\MonCalamari\Domain\Model\Missile;

use Firestorm\MonCalamari\Domain\Events\MissileWasConfiguredWithAttackArea;
use Firestorm\MonCalamari\Domain\Model\AggregateRoot;
use Firestorm\MonCalamari\Domain\Model\Model;

class ProtonTorpedoMissile extends AggregateRoot implements Model
{
    /**
     * @var MissileId
     */
    private $id;

    /**
     * @var MissileArea;
     */
    private $area;

    /**
     * @var MissileSensor
     */
    private $sensor;

    public function id(): MissileId
    {
        return $this->id;
    }

    public function area(): MissileArea
    {
        return $this->area;
    }

    public function sensor(): ?MissileSensor
    {
        return $this->sensor;
    }

    protected function aggregateId(): string
    {
        return $this->id->toString();
    }

    public function sameIdentityAs(Model $other): bool
    {
        /* @var self $other */
        return get_class($this) === get_class($other)
            && $this->id->equals($other->id);
    }

    public static function configureAttackArea(MissileId $id, MissileArea $area): self
    {
        $self = new self();
        $self->recordThat(
            MissileWasConfiguredWithAttackArea::with($id, $area)
        );

        return $self;
    }

    protected function whenMissileWasConfiguredWithAttackArea(
        MissileWasConfiguredWithAttackArea $event
    ): void {
        $this->id = $event->id();
        $this->area = $event->area();
    }
}