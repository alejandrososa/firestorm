<?php

namespace Firestorm\Tests\Shared;

use Faker\Factory;
use Firestorm\MonCalamari\Domain\Model\Missile\MissileRepository;
use Firestorm\Tests\MonCalamari\Domain\Model\Missile\MissileIdMother;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Application;

abstract class FunctionalTestCase extends WebTestCase
{
    /** @var \PHPUnit\Framework\MockObject\MockObject  */
    protected $repository;
    /** @var Application */
    protected $app;
    /** @var  \Faker\Generator */
    protected $fake;
    /** @var \Symfony\Bundle\FrameworkBundle\KernelBrowser  */
    protected $client;

    protected function setUp()
    {
        $this->repository = $this->repository();
        $this->app = new Application();
        $this->client = static::createClient();
    }

    protected function tearDown(): void
    {
        $this->app = null;
        $this->repository = null;
        $this->fake = null;
        $this->client = null;
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

    protected function shouldSaveMissile()
    {
        $this->repository()
            ->expects($this->once())
            ->method('save')
            ->willReturn(null);
    }
}