<?php

namespace Firestorm\Tests\MonCalamari\Domain\Model\Missile;

use Firestorm\MonCalamari\Domain\Events\MissileWasConfiguredWithAttackArea;
use Firestorm\MonCalamari\Domain\Model\AggregateRoot;
use Firestorm\MonCalamari\Domain\Model\Missile\MissileId;
use Firestorm\MonCalamari\Domain\Model\Missile\ProtonTorpedoMissile;
use Firestorm\MonCalamari\Domain\Model\Model;
use Firestorm\Tests\Shared\UnitTestCase;

class ProtonTorpedoTest extends UnitTestCase
{
    private $missile;

    protected function setUp()
    {
        $this->missile = $this->getMissile();
    }

    protected function tearDown()
    {
        parent::tearDown();
        $this->missile;
    }

    private function getMissile()
    {
        return ProtonTorpedoMissile::configureAttackArea(MissileIdMother::random(), MissileAreaMother::random());
    }

    public function provider_inherits_and_implements_class_report()
    {
        return [
            'AggregateRoot' => [AggregateRoot::class],
            'Model' => [Model::class]
        ];
    }

    /**
     * @dataProvider provider_inherits_and_implements_class_report
     * @param string $class
     */
    public function test_the_class_must_implement_and_inherit_from_other_classes($class)
    {
        $this->assertInstanceOf($class, $this->missile);
    }

    public function test_validate_that_a_report_object_has_a_uuid_identifier()
    {
        $this->assertInstanceOf(MissileId::class, $this->missile->id());
    }

    public function test_validate_that_one_ad_is_equal_to_another()
    {
        $this->assertTrue($this->missile->sameIdentityAs($this->missile));
    }

    public function test_validate_that_an_event_is_launched_when_an_ad_is_created()
    {
        $missile = ProtonTorpedoMissile::configureAttackArea(
            MissileIdMother::random(),
            MissileAreaMother::random()
        );

        $events = $this->popRecordedEvent($missile);

        $this->assertCount(1, $events);

        /** @var MissileWasConfiguredWithAttackArea $event */
        $event = $events[0];

        $this->assertSame(MissileWasConfiguredWithAttackArea::class, $event->messageName());
        $this->assertTrue($missile->id()->equals($event->id()));
        $this->assertTrue($missile->area()->equals($event->area()));
    }
}
