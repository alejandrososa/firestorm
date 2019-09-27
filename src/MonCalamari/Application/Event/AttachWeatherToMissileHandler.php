<?php

namespace Firestorm\MonCalamari\Application\Event;

use Firestorm\MonCalamari\Domain\Model\Missile\MissileId;
use Firestorm\MonCalamari\Domain\Model\Missile\MissileRepository;
use Firestorm\MonCalamari\Domain\Model\Missile\MissileSensor;
use Firestorm\MonCalamari\Domain\Model\Missile\SensorRepository;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class AttachWeatherToMissileHandler implements MessageHandlerInterface
{
    /**
     * @var MissileRepository
     */
    private $missileRepository;
    /**
     * @var HttpClientInterface
     */
    private $client;
    /**
     * @var ParameterBagInterface
     */
    private $params;
    /**
     * @var SensorRepository
     */
    private $sensorRepository;

    public function __construct(
        MissileRepository $missileRepository,
        SensorRepository $sensorRepository,
        HttpClientInterface $client,
        ParameterBagInterface $params
    )
    {
        $this->missileRepository = $missileRepository;
        $this->sensorRepository = $sensorRepository;
        $this->client = $client;
        $this->params = $params;
    }

    /**
     * @param AttachWeatherToMissile $event
     */
    public function __invoke(AttachWeatherToMissile $event)
    {
        $missile = $this->missileRepository->get(MissileId::fromString($event->id()));
        $missile->attachWeather($this->getSensor($event));
        $this->missileRepository->save($missile);
    }

    private function getSensor(AttachWeatherToMissile $event)
    {
        if($sensor = $this->sensorRepository->get(MissileId::fromString($event->id()))) {
            return $sensor;
        }

        try {
            list($humidity, $wind) = $this->getWeatherData();
        } catch (TransportExceptionInterface $e) {
        }

        return MissileSensor::with($wind, $humidity);
    }

    /**
     * @return array
     * @throws TransportExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     */
    private function getWeatherData(): array
    {
        $uri = $this->params->get('api.url.weather');
        $key = $this->params->get('api.key.weather');
        $response = $this->client->request('GET', sprintf('%s&APPID=%s', $uri, $key));

        if ($response->getStatusCode() === Response::HTTP_OK) {
            $weather = json_decode($response->getContent(), true);
            $humidity = sprintf('%d%%', $weather['main']['humidity'] ?? 0);
            $wind = sprintf('%s, %02.2f m/s %s ( %02.2f )',
                $weather['weather'][0]['description'] ?? 'none',
                $weather['wind']['speed'] ?? 0,
                $weather['name'] ?? 'city',
                $weather['wind']['deg'] ?? 0,
            );
        }
        return array($humidity, $wind);
    }
}