<?php
namespace Hlgrrnhrdt\Eventable\Domain;

/**
 * AggregateRoot
 *
 * @author Holger Reinhardt <holger.reinhardt@aboutyou.de>
 */
interface AggregateRoot
{
    /**
     * @return DomainEventStream|DomainMessage[]
     */
    public function getUncommittedEvents() : DomainEventStream;

    /**
     * @return string
     */
    public function getAggregateRootId() : string;
}
