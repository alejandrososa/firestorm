<?php

namespace Firestorm\MonCalamari\Application\Query;

use Assert\Assertion;
use Assert\AssertionFailedException;
use Firestorm\MonCalamari\Application\Exception\AreaNotFound;
use Firestorm\MonCalamari\Application\Transformer\MissileArrayTransformer;
use Firestorm\MonCalamari\Domain\Model\Missile\MissileId;
use Firestorm\MonCalamari\Domain\Model\Missile\MissileRepository;
use Firestorm\MonCalamari\Domain\Model\Missile\ProtonTorpedoMissile;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GetAreaByIdHandler implements MessageHandlerInterface
{
	/**
	 * @var MissileRepository
	 */
	private $repository;

	public function __construct(MissileRepository $repository)
	{
		$this->repository = $repository;
	}

	/**
	 * @param GetAreaById $query
	 * @return ProtonTorpedoMissile|null
	 * @throws AreaNotFound
	 */
	public function __invoke(GetAreaById $query)
	{
		$missile = $this->repository->get(MissileId::fromString($query->id()));

		$this->guardCalculateAreaExist($query, $missile);

		return (new MissileArrayTransformer())->write($missile)->read();
	}

	protected function guardCalculateAreaExist(GetAreaById $query, ?ProtonTorpedoMissile $missile = null): void
	{
		try {
			Assertion::isInstanceOf($missile, ProtonTorpedoMissile::class);
		} catch (AssertionFailedException $e) {
			throw AreaNotFound::reason($query->id());
		}
	}
}