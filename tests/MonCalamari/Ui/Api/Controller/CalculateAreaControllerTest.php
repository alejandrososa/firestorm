<?php

namespace Firestorm\Tests\MonCalamari\Ui\Api\Controller;

use Firestorm\MonCalamari\Application\Event\AttachWeatherToMissile;
use Firestorm\MonCalamari\Infrastructure\Persistence\RedisMissileRepository;
use Firestorm\Tests\MonCalamari\Domain\Model\Missile\MissileMother;
use Firestorm\Tests\Shared\FunctionalTestCase;
use Symfony\Component\Messenger\MessageBus;

class CalculateAreaControllerTest extends FunctionalTestCase
{
	private $uuid;
	private $precision;
	private $missile;

	protected function setUp()
	{
		parent::setUp();

		$this->uuid = $this->fake()->uuid;
		$this->precision = 500;
		$this->missile = MissileMother::randomWithIdAndArea($this->uuid, $this->precision);
	}

	protected function tearDown(): void
	{
		parent::tearDown();

		$this->uuid = null;
		$this->precision = null;
		$this->missile = null;
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
		$this->shouldGetMissileById($this->uuid, $this->missile);
		$this->client->getContainer()->set(RedisMissileRepository::class, $this->repository());
		$this->client->request('POST', '/api/v1/missile/calculate-area', $this->getParamsPost());

		$this->assertEquals(400, $this->client->getResponse()->getStatusCode());
	}

	public function test_it_can_calculate_area_with_params()
	{
		$this->shouldConsecutiveGetMissileById($this->uuid, null, $this->missile);
		$this->shouldDispatch(new AttachWeatherToMissile($this->uuid));
		$this->client->getContainer()->set(RedisMissileRepository::class, $this->repository());
		$this->client->getContainer()->set(MessageBus::class, $this->bus());
		$this->client->request('POST', '/api/v1/missile/calculate-area', $this->getParamsPost());

		$this->assertEquals(200, $this->client->getResponse()->getStatusCode());
		$this->assertEquals('"Success"', $this->client->getResponse()->getContent());
	}
}
