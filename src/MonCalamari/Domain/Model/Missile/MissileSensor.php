<?php

namespace Firestorm\MonCalamari\Domain\Model\Missile;

use Assert\Assertion;
use Assert\AssertionFailedException;
use Firestorm\MonCalamari\Domain\Model\ValueObject;

final class MissileSensor
{
    protected $wind;

    protected $humidity;

    protected function __construct($wind, $humidity)
    {
        $this->wind = $wind;
        $this->humidity = $humidity;
    }

    public function wind(): string
    {
        return $this->wind;
    }

    public function humidity(): string
    {
        return $this->humidity;
    }

    protected static function guard(array $weather): void
    {
        try {
            Assertion::keyExists($weather, 'wind', 'wind is empty');
            Assertion::keyExists($weather, 'humidity', 'humidity is empty');
        } catch (AssertionFailedException $e) {
            throw new \DomainException($e->getMessage());
        }
    }

    public function toArray(): array
    {
        return [
            'wind' => $this->wind(),
            'humidity' => $this->humidity()
        ];
    }

    public function equals(ValueObject $other): bool
    {
        /** @var self $other */
        return $this->humidity() === $other->humidity() &&
            $this->wind() === $other->wind();
    }
}
