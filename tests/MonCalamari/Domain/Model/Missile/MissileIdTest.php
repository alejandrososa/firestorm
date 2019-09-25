<?php

namespace Firestorm\Tests\MonCalamari\Domain\Model\Missile;

use Firestorm\MonCalamari\Domain\Model\Missile\MissileId;
use Firestorm\MonCalamari\Domain\Model\ValueObject;
use Firestorm\Tests\MonCalamari\MissileUnitTestCase;
use Ramsey\Uuid\Exception\InvalidUuidStringException;

class MissileIdTest extends MissileUnitTestCase
{
	protected function tearDown()
	{
		parent::tearDown();
	}

    public function test_throw_an_error_if_the_uuid_is_invalid()
    {
    	$this->expectException(InvalidUuidStringException::class);
        MissileId::fromString('bad-uuid');
    }

    public function test_it_create_uuid_from_string()
    {
        $uuidFake = $this->fake()->uuid;
        $uuid = MissileId::fromString($uuidFake);

        $this->assertSame($uuidFake, $uuid->toString());
    }

    /**
     * @test
     * @depends test_it_create_uuid_from_string
     */
    public function test_it_can_be_compared()
    {
        $uuid = $uuidCloned = $this->fake()->uuid;
        $anotherTitle = $this->fake()->uuid;

        $first = MissileId::fromString($uuid);
        $second = MissileId::fromString($uuidCloned);
        $third = MissileId::fromString($anotherTitle);
        $fourth = new class() implements ValueObject {
            public function equals(ValueObject $object): bool
            {
                return false;
            }
        };

        $this->assertTrue($first->equals($second));
        $this->assertFalse($first->equals($third));
        $this->assertFalse($first->equals($fourth));
    }

	public function test_return_valid_uuid()
	{
		$pattern = '/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i';
		$missileId = MissileId::fromString($this->fake()->uuid);
		$this->assertRegExp($pattern, $missileId->toString());
    }
}
