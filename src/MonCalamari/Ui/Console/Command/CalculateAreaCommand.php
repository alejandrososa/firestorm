<?php

namespace Firestorm\MonCalamari\Ui\Console\Command;

use Firestorm\MonCalamari\Application\Command\CalculateArea;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

class CalculateAreaCommand extends Command
{
	protected static $defaultName = 'firestorm:calculate-area';
	/**
	 * @var MessageBusInterface
	 */
	private $bus;

	public function __construct(MessageBusInterface $bus, string $name = null)
	{
		$this->bus = $bus;
		parent::__construct($name);
	}

	protected function configure()
	{
		$this
			->setDescription('Calculate area for Missile.')
			->setHelp('This command allows calculate the area of ​​attack')
			->addArgument('uuid', InputArgument::REQUIRED, 'UUID to identify that area calculation')
			->addArgument('precision', InputArgument::REQUIRED, 'A natural number n');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$output->writeln([
			'Calculate Area',
			'============',
			'',
		]);

		$formatter = $this->getHelper('formatter');
		$io = new SymfonyStyle($input, $output);
		$output->writeln(sprintf('Uuid: %s', $input->getArgument('uuid')));
		$output->writeln(sprintf('precision: %d', $input->getArgument('precision')));

		try {
			$this->bus->dispatch(new CalculateArea(
				$input->getArgument('uuid'),
				$input->getArgument('precision')
			));
			$io->success('Success!');
		} catch (\Exception $e) {
			$output->writeln($formatter->formatBlock(['Error!', $e->getMessage()], 'error'));
		}
	}
}