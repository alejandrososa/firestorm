<?php

namespace Firestorm\Tests\MonCalamari;

use Firestorm\MonCalamari\Domain\Model\Missile\MissileRepository;
use Firestorm\Tests\MonCalamari\Domain\Model\Missile\MissileIdMother;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class ApiUnitTestCase extends WebTestCase
{
	/** @var \Symfony\Bundle\FrameworkBundle\KernelBrowser  */
	protected $client;
	/** @var \PHPUnit\Framework\MockObject\MockObject  */
	protected $repository;

	protected function setUp()
	{
		$this->client = static::createClient();
		$this->repository = $this->repository();
	}

	protected function tearDown(): void
	{
		$this->client = null;
		$this->repository = null;
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
}