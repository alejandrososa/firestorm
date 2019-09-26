<?php

namespace Firestorm\Tests\MonCalamari\Ui\Api\Controller;

use Firestorm\MonCalamari\Infrastructure\Persistence\RedisMissileRepository;
use Firestorm\Tests\MonCalamari\ApiUnitTestCase;
use Firestorm\Tests\MonCalamari\Domain\Model\Missile\MissileMother;

class GetAreaByIdControllerTest extends ApiUnitTestCase
{
	private $uuid;
	private $uri;

	protected function setUp()
	{
		parent::setUp();

		$this->uuid = 'uuid:e856c897-bd9e-4c2d-815a-220bd56605fa';
		$this->uri = sprintf('/api/v1/missile/calculate-area/%s', $this->uuid);
	}

	protected function tearDown(): void
	{
		parent::setUp();

		$this->uuid = null;
		$this->client->getContainer()->set(RedisMissileRepository::class, $this->repository);
	}

	public function test_must_throw_error_if_area_calculate_with_uuid_not_found()
	{
		$this->shouldGetMissileById($this->uuid, null);
		$this->client->getContainer()->set(RedisMissileRepository::class, $this->repository);
		$this->client->request('GET', $this->uri);

		$this->assertEquals(400, $this->client->getResponse()->getStatusCode());
	}

	public function test_it_can_calculate_area_with_params()
	{
		$missile = MissileMother::randomWithId($this->uuid);
		$this->shouldGetMissileById($this->uuid, $missile);
		$this->client->getContainer()->set(RedisMissileRepository::class, $this->repository);
		$this->client->request('GET', $this->uri);

		$responseExpected = json_encode([
			"response" => [
				"area" => $missile->area()->toFloat(),
				"weather" => $missile->sensor() ? $missile->sensor()->toArray() : [],
			]
		]);

		$this->assertEquals(200, $this->client->getResponse()->getStatusCode());
		$this->assertEquals($responseExpected, $this->client->getResponse()->getContent());
	}
}
