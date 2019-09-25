<?php

namespace Firestorm\Tests\MonCalamari\Domain\Model\Missile;

use Firestorm\MonCalamari\Domain\Model\Missile\MissileId;
use Firestorm\MonCalamari\Domain\Model\ValueObject;
use Firestorm\Tests\MonCalamari\MissileUnitTestCase;

class MissileIdTest extends MissileUnitTestCase
{
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
}
