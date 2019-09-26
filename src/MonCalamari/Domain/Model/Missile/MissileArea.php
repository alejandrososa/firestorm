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
    private $precision;

    private function __construct(int $precision)
    {
        $this->guard($precision);
        $this->precision = $precision;
        $this->area = $this->approximate($precision);
    }

    private function guard(int $value): void
    {
        try {
            Assertion::notEmpty($value, 'precision is empty');
			Assertion::false($value > self::MAX_ACCURACY, 'precision greater than allowed');
			Assertion::false($value < self::MIN_ACCURACY, 'precision less than allowed');
        } catch (AssertionFailedException $e) {
            throw new \DomainException($e->getMessage(), $value);
        }
    }

	private function approximate($arg): float
	{
		return rand(self::MIN_ACCURACY, $arg) / self::MAX_ACCURACY;
	}

    public static function fromInt(int $precision): self
    {
        return new self($precision);
    }

    public function toFloat(): float
    {
        return $this->area;
    }

    public function toInt(): float
    {
        return $this->precision;
    }

    public function equals(ValueObject $object): bool
    {
        /** @var self $object */
        return get_class($this) === get_class($object)
            && $this->area === $object->area;
    }
}
