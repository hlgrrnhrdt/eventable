<?php
namespace Hlgrrnhrdt\Eventable\EventSourcing;

use Hlgrrnhrdt\Eventable\Domain\AggregateRoot;
use Hlgrrnhrdt\Eventable\Domain\DomainMessage;
use Hlgrrnhrdt\Eventable\Domain\DomainEventStream;
use ReflectionClass;

/**
 * EventSourcedAggregateRoot
 *
 * @author Holger Reinhardt <holger.reinhardt@aboutyou.de>
 */
abstract class EventSourcedAggregateRoot implements AggregateRoot
{
    /**
     * @var DomainMessage[]
     */
    private $uncommittedEvents = [];

    /**
     * @var int
     */
    private $playhead = -1;

    /**
     * @param DomainEventStream $stream
     *
     * @return static
     */
    public static function reconstituteFromHistory(DomainEventStream $stream)
    {
        return (new static)->replay($stream);
    }

    /**
     * @param DomainEventStream $stream
     *
     * @return static
     */
    public function replay(DomainEventStream $stream)
    {
        foreach ($stream as $event) {
            $this->handleRecursively($event->getPayload());
        }

        return $this;
    }

    /**
     *
     */
    public function record($event)
    {
        $this->handleRecursively($event);

        $this->uncommittedEvents[] = DomainMessage::record(
            $this->getAggregateRootId(),
            ++$this->playhead,
            $event
        );
    }

    /**
     *
     */
    public function handle($event)
    {
        $method = $this->getApplyMethod($event);
        if (false === method_exists($this, $method)) {
            throw new \InvalidArgumentException;
        }

        $this->$method($event);
    }

    /**
     * @param $event
     */
    protected function handleRecursively($event)
    {
        $this->handle($event);
    }

    /**
     * @return DomainEventStream|DomainMessage[]
     */
    public function getUncommittedEvents() : DomainEventStream
    {
        return new DomainEventStream($this->uncommittedEvents);
    }

    private function getApplyMethod($event)
    {
        return 'apply' . (new ReflectionClass($event))->getShortName();
    }
}
