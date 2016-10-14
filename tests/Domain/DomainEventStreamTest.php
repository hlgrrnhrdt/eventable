<?php
namespace Hlgrrnhrdt\Test\Eventable\Domain;

use Hlgrrnhrdt\Eventable\Domain\DomainEventStream;
use Hlgrrnhrdt\Eventable\Test\TestCase;

/**
 * DomainEventStreamTest
 *
 * @author Holger Reinhardt <holger.reinhardt@aboutyou.de>
 */
class DomainEventStreamTest extends TestCase
{
    /**
     *
     */
    public function test_it_returns_all_events_when_traversing()
    {
        $expectedEvents = ['event1', 'event2', 'event3'];
        $stream = new DomainEventStream($expectedEvents);

        $events = [];
        foreach ($stream as $event) {
            $events[] = $event;
        }

        $this->assertEquals($expectedEvents, $events);
    }
}
