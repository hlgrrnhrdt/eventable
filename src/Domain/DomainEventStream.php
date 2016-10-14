<?php
namespace Hlgrrnhrdt\Eventable\Domain;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * DomainEventStream
 *
 * @author Holger Reinhardt <holger.reinhardt@aboutyou.de>
 */
class DomainEventStream implements IteratorAggregate
{
    /**
     * @var DomainMessage[]
     */
    private $events = [];

    /**
     * DomainEventStream constructor.
     *
     * @param DomainMessage[] $events
     */
    public function __construct(array $events)
    {
        $this->events = $events;
    }

    /**
     * @return ArrayIterator|DomainMessage[]
     */
    public function getIterator()
    {
        return new ArrayIterator($this->events);
    }
}
