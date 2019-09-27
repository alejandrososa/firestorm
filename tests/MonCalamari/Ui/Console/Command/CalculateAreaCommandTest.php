<?php

namespace Firestorm\Tests\MonCalamari\Ui\Console\Command;

use Firestorm\MonCalamari\Domain\Model\Missile\MissileArea;
use Firestorm\MonCalamari\Infrastructure\Persistence\RedisMissileRepository;
use Firestorm\MonCalamari\Ui\Console\Command\CalculateAreaCommand;
use Firestorm\Tests\MonCalamari\Domain\Model\Missile\MissileMother;
use Firestorm\Tests\Shared\FunctionalTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Messenger\MessageBus;

class CalculateAreaCommandTest extends FunctionalTestCase
{
    private $commandTester;
    private $uuid;
	private $missile;

	protected function setUp()
    {
        parent::setUp();
        $this->commandTester = new CommandTester($this->getCommand());
        $this->uuid = $this->fake()->uuid;
		$this->missile = MissileMother::randomWithId($this->uuid);
	}

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->commandTester = null;
        $this->uuid = null;
		$this->missile = null;
	}

    protected function getCommand(): ?Command
	{
		$this->app->add(
		    new CalculateAreaCommand(static::$container->get('messenger.bus.default'))
        );
		return $this->app->find('firestorm:calculate-area');
	}

	public function test_validate_exists_command()
	{
		$command = $this->getCommand();
		$this->assertInstanceOf(CalculateAreaCommand::class, $command);
	}

    public function test_execute_command_error()
    {
        $this->shouldGetMissileById($this->uuid, MissileMother::randomWithId($this->uuid));
        $this->client->getContainer()->set(RedisMissileRepository::class, $this->repository());

        $this->commandTester->execute([
            'command' => $this->getCommand()->getName(),
            'uuid' => $this->uuid,
            'precision' => MissileArea::MIN_ACCURACY
        ]);
        $output = $this->commandTester->getDisplay();

        $this->assertContains('Error!', $output);
        $this->assertContains(sprintf('Upss, area with uuid \'%s\' already exists', $this->uuid), $output);
    }

	public function test_execute_command_success()
	{
		$this->shouldConsecutiveGetMissileById($this->uuid, null, $this->missile);
		$this->shouldSaveMissile();
        $this->client->getContainer()->set(RedisMissileRepository::class, $this->repository());
		$this->client->getContainer()->set(MessageBus::class, $this->bus());

		$this->commandTester->execute([
			'command' => $this->getCommand()->getName(),
            'uuid' => $this->uuid,
            'precision' => MissileArea::MIN_ACCURACY
		]);
		$output = $this->commandTester->getDisplay();

		$this->assertContains('[OK] Success', $output);
	}
}
