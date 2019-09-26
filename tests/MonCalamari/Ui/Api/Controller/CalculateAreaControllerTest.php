<?php

namespace Firestorm\Tests\MonCalamari\Ui\Api\Controller;

use Firestorm\MonCalamari\Infrastructure\Persistence\RedisMissileRepository;
use Firestorm\Tests\MonCalamari\Domain\Model\Missile\MissileMother;
use Firestorm\Tests\Shared\FunctionalTestCase;

class CalculateAreaControllerTest extends FunctionalTestCase
{
	private $uuid;
	private $precision;

	protected function setUp()
	{
		parent::setUp();

		$this->uuid = $this->fake()->uuid;
		$this->precision = 500;
	}

	protected function tearDown(): void
	{
		parent::tearDown();

		$this->uuid = null;
		$this->precision = null;
	}

	protected function getParamsPost()
	{
		return [
			'uuid' => $this->uuid,
			'precision' => $this->precision
		];
	}

	public function test_must_throw_error_if_area_calculate_with_uuid_already_exists()
	{
		$this->shouldGetMissileById($this->uuid, MissileMother::randomWithIdAndArea($this->uuid, $this->precision));
		$this->client->getContainer()->set(RedisMissileRepository::class, $this->repository);
		$this->client->request('POST', '/api/v1/missile/calculate-area', $this->getParamsPost());

		$this->assertEquals(400, $this->client->getResponse()->getStatusCode());
	}

	public function test_it_can_calculate_area_with_params()
	{
		$this->shouldGetMissileById($this->uuid, null);
		$this->client->getContainer()->set(RedisMissileRepository::class, $this->repository);
		$this->client->request('POST', '/api/v1/missile/calculate-area', $this->getParamsPost());

		$this->assertEquals(200, $this->client->getResponse()->getStatusCode());
		$this->assertEquals('"Success"', $this->client->getResponse()->getContent());
	}
}
