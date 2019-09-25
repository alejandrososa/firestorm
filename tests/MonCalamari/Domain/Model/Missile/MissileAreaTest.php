<?php

namespace Firestorm\Tests\MonCalamari\Domain\Model\Missile;

use Firestorm\MonCalamari\Domain\Model\Missile\MissileArea;
use Firestorm\Tests\MonCalamari\MissileUnitTestCase;

class MissileAreaTest extends MissileUnitTestCase
{
    public function test_throw_an_error_if_the_value_is_higher()
    {
        $this->expectException(\DomainException::class);
        $n = $this->fake()->numberBetween(MissileArea::MAX_ACCURACY, (MissileArea::MAX_ACCURACY + 1));
        MissileArea::fromInt($n);
    }

    public function test_throw_an_error_if_the_value_is_less()
    {
        $this->expectException(\DomainException::class);
        $n = $this->fake()->numberBetween(MissileArea::MIN_ACCURACY, (MissileArea::MIN_ACCURACY - 1));
        MissileArea::fromInt($n);
    }
}