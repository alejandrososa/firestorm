<?php

namespace Firestorm\MonCalamari\Application\Command;

use Assert\Assertion;
use Assert\AssertionFailedException;
use Firestorm\MonCalamari\Application\Event\AttachWeatherToMissile;
use Firestorm\MonCalamari\Application\Exception\CalculatedAreaAlreadyExists;
use Firestorm\MonCalamari\Domain\Model\Missile\MissileArea;
use Firestorm\MonCalamari\Domain\Model\Missile\MissileId;
use Firestorm\MonCalamari\Domain\Model\Missile\MissileRepository;
use Firestorm\MonCalamari\Domain\Model\Missile\ProtonTorpedoMissile;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;

class CalculateAreaHandler implements MessageHandlerInterface
{
	/**
	 * @var MissileRepository
	 */
	private $repository;
    /**
     * @var MessageBusInterface
     */
    private $bus;

    public function __construct(MissileRepository $repository, MessageBusInterface $bus)
	{
		$this->repository = $repository;
        $this->bus = $bus;
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

		$event = new AttachWeatherToMissile($command->id());
		$this->bus->dispatch(
            (new Envelope($event))
                ->with(new DispatchAfterCurrentBusStamp())
        );
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