<?php

namespace Firestorm\Tests\MonCalamari\Ui\Console\Command;

use Firestorm\MonCalamari\Ui\Console\Command\CalculateAreaCommand;
use Firestorm\Tests\MonCalamari\ConsoleUnitTestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class CalculateAreaCommandTest extends ConsoleUnitTestCase
{
	/**
	 * @var Application
	 */
	private $app;

	public static function setUpBeforeClass()
	{
		self::bootKernel();
	}

	protected function setUp()
	{

	}

	protected function tearDown()
	{
		$this->app = null;
	}

	protected function getCommand(): ?Command
	{
		$bus = static::$container->get('messenger.bus.default');
		$this->app->add(new CalculateAreaCommand($bus));
		return $this->app->find('firestorm:calculate-area');
	}

	public function test_validate_exists_command()
	{
		$command = $this->getCommand();
		$this->assertInstanceOf(CalculateAreaCommand::class, $command);
	}

	public function test_execute_command()
	{
		$command = $this->getCommand();
		$commandTester = new CommandTester($command);
		$commandTester->execute([
			'command' => $command->getName(),
		]);
		$output = $commandTester->getDisplay();
		$this->assertContains('Customer report generated successfully!', $output);
	}
}
