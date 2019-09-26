<?php

namespace Firestorm\MonCalamari\Application\Command;

use Assert\Assertion;
use Assert\AssertionFailedException;
use Firestorm\MonCalamari\Application\Exception\CalculatedAreaAlreadyExists;
use Firestorm\MonCalamari\Domain\Model\Missile\MissileId;
use Firestorm\MonCalamari\Domain\Model\Missile\MissileRepository;
use Firestorm\MonCalamari\Domain\Model\Missile\ProtonTorpedoMissile;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CalculateAreaHandler implements MessageHandlerInterface
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
	 * @param CalculateArea $command
	 * @throws CalculatedAreaAlreadyExists
	 */
	public function __invoke(CalculateArea $command)
	{
		$missile = $this->repository->get(MissileId::fromString($command->id()));

		$this->guardCalculateAreaAlreadyExist($command, $missile);
	}

	protected function guardCalculateAreaAlreadyExist(CalculateArea $command, ?ProtonTorpedoMissile $missile = null): void
	{
		try {
			Assertion::isInstanceOf($missile, ProtonTorpedoMissile::class);
			Assertion::eq($missile->id(), $command->id());
		} catch (AssertionFailedException $e) {
			throw new CalculatedAreaAlreadyExists($command->id());
		}
	}
}