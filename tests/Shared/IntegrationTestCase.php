<?php
namespace Firestorm\Tests\Shared;

use Faker\Factory;
use Firestorm\MonCalamari\Domain\Model\Missile\MissileRepository;
use Firestorm\MonCalamari\Domain\Model\Missile\SensorRepository;
use Firestorm\Tests\MonCalamari\Domain\Model\Missile\MissileIdMother;
use Firestorm\Tests\Shared\UnitTestCase as BaseUnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;

abstract class IntegrationTestCase extends BaseUnitTestCase
{
    protected $fake;
	protected $missileRepository;
    protected $sensorRepository;
    protected $bus;

    protected function tearDown()
	{
		$this->fake = null;
		$this->missileRepository = null;
		$this->sensorRepository = null;
		$this->bus = null;
	}

	/** @return \Faker\Generator */
    protected function fake()
    {
        return $this->fake = $this->fake ?: Factory::create();
    }

	/** @return MissileRepository|MockObject */
	protected function missileRepository()
	{
		return $this->missileRepository = $this->missileRepository ?: $this->createMock(MissileRepository::class);
	}

	/** @return SensorRepository|MockObject */
	protected function sensorRepository()
	{
		return $this->sensorRepository = $this->sensorRepository ?: $this->createMock(SensorRepository::class);
	}

	/** @return MessageBusInterface|MockObject */
	protected function bus()
	{
		return $this->bus = $this->bus ?: $this->createMock(MessageBusInterface::class);
	}

	protected function shouldGetMissileById(string $id, $object = null)
	{
		$this->missileRepository()
			->expects($this->atLeastOnce())
			->method('get')
            ->with($this->equalTo(MissileIdMother::create($id)))
			->willReturn($object);
	}

    protected function shouldSaveMissileWithAreaCalculated(): void
    {
        $this->missileRepository()
            ->expects($this->once())
            ->method('save')
            ->willReturn(null);
    }

	protected function shouldDispatch($message = null)
	{
		$this->bus()->expects($this->atLeastOnce())
			->method('dispatch')
			->willReturn(new Envelope($message));
    }
}
