<?php
/**
 * web, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2019, 10/04/2019 15:56
 */

namespace Firestorm\Tests\MonCalamari;

use Faker\Factory;
use Firestorm\MonCalamari\Domain\Model\Missile\MissileRepository;
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
			->willReturn($object);
	}
}
