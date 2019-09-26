<?php

namespace Firestorm\Tests\MonCalamari\Application\Transformer;

use Firestorm\MonCalamari\Application\Transformer\MissileArrayTransformer;
use Firestorm\Tests\MonCalamari\Domain\Model\Missile\MissileMother;
use PHPUnit\Framework\TestCase;

class MissileArrayTransformerTest extends TestCase
{
	private $transformer;

	protected function setUp()
	{
		$this->transformer = new MissileArrayTransformer();
	}
	
	protected function tearDown()
	{
		$this->transformer = null;
	}

	public function providerObjects()
	{
		$missile = MissileMother::random();
		$expectedDataMissile = [
			'area' => $missile->area()->toFloat(),
			'weather' => $missile->sensor() ? $missile->sensor()->toArray() : []
		];

		return [
			'array type' => [array('valueOne','valueOne'), []],
			'stdClass object' => [new \stdClass(), []],
			'missile object' => [$missile, $expectedDataMissile]
		];
	}

	/**
	 * @dataProvider providerObjects
	 * @param $object
	 * @param $expectedResult
	 */
	public function test_it_can_transformer_objects($object, $expectedResult)
	{
		$result = $this->transformer->write($object)->read();
		$this->assertSame($expectedResult, $result);
	}
}
