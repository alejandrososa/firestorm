<?php
namespace Firestorm\Tests\MonCalamari;

use Faker\Factory;
use Firestorm\MonCalamari\Domain\Model\Missile\MissileRepository;
use Firestorm\Tests\MonCalamari\Domain\Model\Missile\MissileIdMother;
use Firestorm\Tests\Shared\UnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;

abstract class MissileUnitTestCase extends UnitTestCase
{
    protected $fake;
	protected $repository;

    protected function tearDown()
	{
		$this->fake = null;
		$this->repository = null;
	}

	/** @return \Faker\Generator */
    protected function fake()
    {
        return $this->fake = $this->fake ?: Factory::create();
    }

	/** @return MissileRepository|MockObject */
	protected function repository()
	{
		return $this->repository = $this->repository ?: $this->createMock(MissileRepository::class);
	}

	protected function shouldGetMissileById(string $id, $object = null)
	{
		$this->repository()
			->expects($this->atLeastOnce())
			->method('get')
            ->with($this->equalTo(MissileIdMother::create($id)))
			->willReturn($object);
	}

    protected function shouldSaveMissileWithAreaCalculated(): void
    {
        $this->repository()
            ->expects($this->once())
            ->method('save')
            ->willReturn(null);
    }
}
