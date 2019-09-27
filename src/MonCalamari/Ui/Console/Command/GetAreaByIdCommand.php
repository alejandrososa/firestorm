<?php

namespace Firestorm\MonCalamari\Ui\Console\Command;

use Exception;
use Firestorm\MonCalamari\Application\Query\GetAreaById;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class GetAreaByIdCommand extends Command
{
	protected static $defaultName = 'firestorm:get-area-by-id';
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
			->setDescription('Get area stored by id.')
			->setHelp('This command allows get area calculated of ​​attack stored')
			->addArgument('uuid', InputArgument::REQUIRED, 'UUID to identify that area calculation');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$output->writeln([
			'Get Area by Id',
			'============',
			'',
		]);

		$formatter = $this->getHelper('formatter');
		$io = new SymfonyStyle($input, $output);
		$output->writeln(sprintf('Uuid: %s', $input->getArgument('uuid')));

		try {
			$envelope = $this->bus->dispatch(new GetAreaById($input->getArgument('uuid')));
			$handledStamp = $envelope->last(HandledStamp::class);
			$io->text($this->getResponsePretty(['response'=> $handledStamp->getResult()]));
		} catch (Exception $e) {
			$output->writeln($formatter->formatBlock(['Error!', $e->getMessage()], 'error'));
		}
	}

	private function getResponsePretty($data)
	{
		$response = new JsonResponse($data);
		$response->setEncodingOptions( $response->getEncodingOptions() | JSON_PRETTY_PRINT );
		return $response->getContent();
	}
}