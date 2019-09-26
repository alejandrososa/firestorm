<?php

namespace Firestorm\Tests\MonCalamari\Ui\Console\Command;

use Firestorm\MonCalamari\Infrastructure\Persistence\RedisMissileRepository;
use Firestorm\MonCalamari\Ui\Console\Command\GetAreaByIdCommand;
use Firestorm\Tests\MonCalamari\Domain\Model\Missile\MissileMother;
use Firestorm\Tests\Shared\FunctionalTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class GetAreaByIdCommandTest extends FunctionalTestCase
{
    private $commandTester;
    private $uuid;

    protected function setUp()
    {
        parent::setUp();
        $this->commandTester = new CommandTester($this->getCommand());
        $this->uuid = $this->fake()->uuid;
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->commandTester = null;
        $this->uuid = null;
    }

    protected function getCommand(): ?Command
	{
		$this->app->add(
		    new GetAreaByIdCommand(static::$container->get('messenger.bus.default'))
        );
		return $this->app->find('firestorm:get-area-by-id');
	}

	public function test_validate_exists_command()
	{
		$command = $this->getCommand();
		$this->assertInstanceOf(GetAreaByIdCommand::class, $command);
	}

    public function test_execute_command_error()
    {
        $this->shouldGetMissileById($this->uuid, null);
        $this->client->getContainer()->set(RedisMissileRepository::class, $this->repository());

        $this->commandTester->execute([
            'command' => $this->getCommand()->getName(),
            'uuid' => $this->uuid
        ]);
        $output = $this->commandTester->getDisplay();

        $this->assertContains('Error!', $output);
        $this->assertContains(sprintf('Upss, area with uuid \'%s\' not found', $this->uuid), $output);
    }

	public function test_execute_command_success()
	{
        $this->shouldGetMissileById($this->uuid, MissileMother::randomWithId($this->uuid));
        $this->client->getContainer()->set(RedisMissileRepository::class, $this->repository());

		$this->commandTester->execute([
			'command' => $this->getCommand()->getName(),
            'uuid' => $this->uuid
		]);
		$output = $this->commandTester->getDisplay();

		$this->assertContains('response', $output);
		$this->assertContains('area', $output);
		$this->assertContains('weather', $output);
	}
}
