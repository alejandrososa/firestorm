<?php
namespace Firestorm\MonCalamari\Domain\Model;

use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\AggregateRoot as ModelAggregateRoot;

abstract class AggregateRoot extends ModelAggregateRoot
{
    /**
     * Apply given event
     */
    protected function apply(AggregateChanged $event): void
    {
        $handler = $this->determineEventHandlerMethodFor($event);

        if(!method_exists($this, $handler)){
            throw new \RuntimeException(sprintf(
                'Missing event handler method %s for aggregate root %s',
                $handler,
                get_class($this)
            ));
        }

        $this->{$handler}($event);
    }

    private function determineEventHandlerMethodFor(AggregateChanged $event)
    {
        $methodName = implode(array_slice(explode('\\', get_class($event)), -1));
        return sprintf('when%s', $methodName);
    }
}