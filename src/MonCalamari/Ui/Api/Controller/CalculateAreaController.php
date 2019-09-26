<?php

namespace Firestorm\MonCalamari\Ui\Api\Controller;

use Firestorm\MonCalamari\Application\Command\CalculateArea;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

final class CalculateAreaController
{
	public function __invoke(Request $request, MessageBusInterface $bus)
	{
		try {
			$post = $request->request;
			$bus->dispatch(new CalculateArea(
				$post->get('uuid'),
				$post->get('precision')
			));
		} catch (\Exception $e) {
			return new JsonResponse($e->getMessage(), Response::HTTP_BAD_REQUEST);
		}

		return new JsonResponse('Success', Response::HTTP_OK);
	}
}