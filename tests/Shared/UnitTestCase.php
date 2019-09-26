<?php

namespace Firestorm\Tests\Shared;

use ArrayIterator;
use Faker\Factory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Prooph\EventSourcing\Aggregate\AggregateType;
use Prooph\EventSourcing\AggregateRoot;
use Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator;

abstract class UnitTestCase extends TestCase
{
    /**
     * @var AggregateTranslator
     */
    private $aggregateTranslator;

    protected $fake;

    /** @return \Faker\Generator */
    protected function fake()
    {
        return $this->fake = $this->fake ?: Factory::create();
    }

    protected function mock($className): MockObject
    {
        return $this->createMock($className);
    }

    protected function popRecordedEvent(AggregateRoot $aggregateRoot): array
    {
        return $this->getAggregateTranslator()->extractPendingStreamEvents($aggregateRoot);
    }

    protected function reconstituteAggregateFromHistory(string $aggregateRootClass, array $events)
    {
        return $this->getAggregateTranslator()->reconstituteAggregateFromHistory(
            AggregateType::fromAggregateRootClass($aggregateRootClass),
            new ArrayIterator($events)
        );
    }

    private function getAggregateTranslator(): AggregateTranslator
    {
        if (null === $this->aggregateTranslator) {
            $this->aggregateTranslator = new AggregateTranslator();
        }
        return $this->aggregateTranslator;
    }
}
