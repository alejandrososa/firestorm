<?php

namespace Firestorm\MonCalamari\Domain\Model\Missile;

use Assert\Assertion;
use Assert\AssertionFailedException;
use Firestorm\MonCalamari\Domain\Model\ValueObject;

final class MissileArea implements ValueObject
{
    const MIN_ACCURACY = 100;
    const MAX_ACCURACY = 15000;

    private $area;

    private function __construct(int $area)
    {
        $this->guard($area);
        $this->area = $area;
    }

    private function guard(string $value): void
    {
        try {
            Assertion::notEmpty($value, 'precision is empty');
            Assertion::greaterThan($value, self::MAX_ACCURACY, 'precision out of limit');
            Assertion::lessThan($value, self::MAX_ACCURACY, 'precision out of limit');
        } catch (AssertionFailedException $e) {
            throw new \DomainException($e->getMessage(), $value);
        }
    }

    public static function fromInt(int $area): self
    {
        return new self($area);
    }

    public function toInt(): int
    {
        return $this->area;
    }

    public function equals(ValueObject $object): bool
    {
        /** @var self $object */
        return get_class($this) === get_class($object)
            && $this->area === $object->area;
    }
}
