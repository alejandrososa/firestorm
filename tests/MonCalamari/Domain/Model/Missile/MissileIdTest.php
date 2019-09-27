<?php

namespace Firestorm\Tests\MonCalamari\Domain\Model\Missile;

use Firestorm\MonCalamari\Domain\Model\Missile\MissileId;
use Firestorm\MonCalamari\Domain\Model\ValueObject;
use Firestorm\Tests\Shared\UnitTestCase;
use Ramsey\Uuid\Exception\InvalidUuidStringException;

class MissileIdTest extends UnitTestCase
{
	private $uuid;

	protected function setUp()
	{
		parent::setUp();
		$this->uuid = $this->fake()->uuid;
	}

	protected function tearDown()
	{
		parent::tearDown();
		$this->uuid = null;
	}

    public function test_throw_an_error_if_the_uuid_is_invalid()
    {
    	$this->expectException(InvalidUuidStringException::class);
        MissileId::fromString('bad-uuid');
    }

    public function test_it_create_uuid_from_string()
    {
        $uuid = MissileId::fromString($this->uuid);

        $this->assertSame($this->uuid, $uuid->toString());
    }

    /**
     * @depends test_it_create_uuid_from_string
     */
    public function test_it_can_be_compared()
    {
        $uuid = $uuidCloned = $this->uuid;
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
		$missileId = MissileId::fromString($this->uuid);
		$this->assertRegExp($pattern, $missileId->toString());
    }

	public function test_it_can_cast_to_string()
	{
		$missileId = MissileId::fromString($this->uuid);
		$this->assertSame($this->uuid, (string)$missileId);
    }
}
