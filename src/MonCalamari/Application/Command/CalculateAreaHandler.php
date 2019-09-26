<?php

namespace Firestorm\MonCalamari\Application\Command;

use Assert\Assertion;
use Assert\AssertionFailedException;
use Firestorm\MonCalamari\Application\Exception\CalculatedAreaAlreadyExists;
use Firestorm\MonCalamari\Domain\Model\Missile\MissileArea;
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
	 * @return string
	 * @throws CalculatedAreaAlreadyExists
	 */
	public function __invoke(CalculateArea $command)
	{
		$missile = $this->repository->get(MissileId::fromString($command->id()));

		$this->guardCalculateAreaAlreadyExist($command, $missile);

		$missile = ProtonTorpedoMissile::configureAttackArea(
		    MissileId::fromString($command->id()),
		    MissileArea::fromInt($command->precision()) 
        );
		$this->repository->save($missile);
	}

	protected function guardCalculateAreaAlreadyExist(
	    CalculateArea $command,
        ?ProtonTorpedoMissile $missile = null
    ): void {
		try {
			Assertion::notIsInstanceOf($missile, ProtonTorpedoMissile::class);
		} catch (AssertionFailedException $e) {
			throw CalculatedAreaAlreadyExists::reason($command->id());
		}
	}
}