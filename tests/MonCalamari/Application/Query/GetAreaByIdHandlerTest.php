<?php

namespace Firestorm\Tests\MonCalamari\Application\Query;

use Firestorm\MonCalamari\Application\Exception\AreaNotFound;
use Firestorm\MonCalamari\Application\Query\GetAreaById;
use Firestorm\MonCalamari\Application\Query\GetAreaByIdHandler;
use Firestorm\Tests\MonCalamari\Domain\Model\Missile\MissileMother;
use Firestorm\Tests\Shared\IntegrationTestCase;

class GetAreaByIdHandlerTest extends IntegrationTestCase
{
	private $handler;

	protected function setUp()
	{
		$this->handler = new GetAreaByIdHandler(
			$this->missileRepository()
		);
	}

	protected function tearDown(): void
	{
		parent::tearDown();
		$this->handler = null;
	}

	private function getAreaById(): GetAreaById
	{
		return GetAreaByIdMother::random();
	}

	public function test_validate_that_the_query_exists()
	{
		$this->assertInstanceOf(GetAreaById::class, $this->getAreaById());
	}

	public function test_validate_that_an_exception_returns_if_the_calculated_area_not_found()
	{
		$this->expectException(AreaNotFound::class);

		$query = $this->getAreaById();
		$this->shouldGetMissileById($query->id(), null);

		$this->handler->__invoke($query);
	}

	public function test_you_can_find_a_calculated_area()
	{
		$query = $this->getAreaById();

		$missile = MissileMother::randomWithId($query->id());
		$this->shouldGetMissileById($query->id(), $missile);

        $result = $this->handler->__invoke($query);
        $expectedResult = [
			'area' => $missile->area()->toFloat(),
			'weather' => $missile->sensor() ? $missile->sensor()->toArray() : []
		];

        $this->assertSame($expectedResult, $result);
	}
}
