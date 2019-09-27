<?php

namespace Firestorm\MonCalamari\Domain\Model\Missile;

use Firestorm\MonCalamari\Domain\Model\ValueObject;

final class MissileSensor implements ValueObject
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
            'wind' => $this->wind() ?? null,
            'humidity' => $this->humidity() ?? null
        ];
    }

    public function equals(ValueObject $other): bool
    {
        /** @var self $other */
        return $this->humidity() === $other->humidity() &&
            $this->wind() === $other->wind();
    }
}
