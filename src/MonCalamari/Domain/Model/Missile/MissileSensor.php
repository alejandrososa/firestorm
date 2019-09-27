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

    public static function with(string $wind, string $humidity)
    {
        return new self($wind, $humidity);
    }

    public function wind(): string
    {
        return $this->wind;
    }

    public function humidity(): string
    {
        return $this->humidity;
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
