<?php

namespace Firestorm\MonCalamari\Domain\Model\Missile;

use Firestorm\MonCalamari\Domain\Model\ValueObject;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class MissileId implements ValueObject
{
    private $uuid;

    private function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    public static function generate(): self
    {
        return new self(Uuid::uuid4());
    }

    public static function fromString(string $adId): self
    {
        return new self(Uuid::fromString($adId));
    }

    public function toString(): string
    {
        return $this->uuid->toString();
    }

    public function __toString(): string
    {
        return $this->uuid->toString();
    }

    public function equals(ValueObject $object): bool
    {
        /** @var self $object */
        return get_class($this) === get_class($object)
            && $this->uuid->equals($object->uuid);
    }
}
