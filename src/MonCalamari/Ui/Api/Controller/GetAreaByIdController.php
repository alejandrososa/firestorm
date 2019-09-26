<?php

namespace Firestorm\MonCalamari\Ui\Api\Controller;

use Firestorm\MonCalamari\Application\Query\GetAreaById;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class GetAreaByIdController
{
	public function __invoke(Request $request, ?string $uuid, MessageBusInterface $bus)
	{
		try {
			$envelope = $bus->dispatch(new GetAreaById($uuid));
			$handledStamp = $envelope->last(HandledStamp::class);
		} catch (\Exception $e) {
			return new JsonResponse($e->getMessage(), Response::HTTP_BAD_REQUEST);
		}

		return new JsonResponse(['response'=> $handledStamp->getResult()], Response::HTTP_OK);
	}
}