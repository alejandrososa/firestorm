<?php

namespace Firestorm\Tests\MonCalamari\Domain\Model\Missile;

use DomainException;
use Firestorm\MonCalamari\Domain\Model\Missile\MissileArea;
use Firestorm\Tests\Shared\UnitTestCase;

class MissileAreaTest extends UnitTestCase
{
	protected function tearDown()
	{
		parent::tearDown();
	}

	public function test_throw_an_error_if_the_value_is_higher()
    {
        $this->expectException(DomainException::class);
        $n = $this->fake()->numberBetween(MissileArea::MAX_ACCURACY + 1, (MissileArea::MAX_ACCURACY + 5));
        MissileArea::fromInt($n);
    }

    public function test_throw_an_error_if_the_value_is_less()
    {
        $this->expectException(DomainException::class);
        $n = $this->fake()->numberBetween(0, (MissileArea::MIN_ACCURACY - 1));
        MissileArea::fromInt($n);
    }

	/**
	 * @depends test_throw_an_error_if_the_value_is_higher
	 * @depends test_throw_an_error_if_the_value_is_less
	 */
    public function test_it_return_the_area_to_attack()
    {
        $n = $this->fake()->numberBetween(MissileArea::MIN_ACCURACY, MissileArea::MAX_ACCURACY);
		$missile = MissileArea::fromInt($n);

        $this->assertIsFloat($missile->toFloat());
    }
}
