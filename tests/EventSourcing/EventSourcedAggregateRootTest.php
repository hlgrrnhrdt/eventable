<?php
namespace Hlgrrnhrdt\Eventable\Test\EventSourcing;

use Hlgrrnhrdt\Eventable\EventSourcing\EventSourcedAggregateRoot;
use Hlgrrnhrdt\Eventable\Test\TestCase;

/**
 * EventSourcedAggregateRootTest
 *
 * @author Holger Reinhardt <holger.reinhardt@aboutyou.de>
 */
class EventSourcedAggregateRootTest extends TestCase
{
    /**
     *
     */
    public function test_it_records_using_an_incrementing_playhead()
    {
        $aggregateRoot = TestAggregateRoot::create();
        $this->assertInstanceOf(EventSourcedAggregateRoot::class, $aggregateRoot);

        $aggregateRoot->doSomething();
        $aggregateRoot->doSomethingElse();

        $playhead = 0;
        foreach ($aggregateRoot->getUncommittedEvents() as $event) {
            $this->assertEquals($playhead++, $event->getPlayhead());
        }

        $this->assertEquals(2, $playhead);
    }

    /**
     *
     */
    public function test_it_changes_state_when_recording()
    {
        $aggregateRoot = TestAggregateRoot::create();
        $this->assertEquals(null, $aggregateRoot->done);

        $aggregateRoot->doSomething();
        $this->assertEquals('something', $aggregateRoot->done);

        $aggregateRoot->doSomethingElse();
        $this->assertEquals('something else', $aggregateRoot->done);
    }

    /**
     *
     */
    public function test_it_collects_uncommitted_events()
    {
        $aggregateRoot = TestAggregateRoot::create();
        $this->assertCount(0, $aggregateRoot->getUncommittedEvents());

        $aggregateRoot->doSomething();
        $this->assertCount(1, $aggregateRoot->getUncommittedEvents());

        $aggregateRoot->doSomethingElse();
        $this->assertCount(2, $aggregateRoot->getUncommittedEvents());
    }

    /**
     *
     */
    public function test_it_reconstitutes_from_history()
    {
        $aggregateRoot = TestAggregateRoot::create();
        $aggregateRoot->doSomething();
        $aggregateRoot->doSomethingElse();

        $history = $aggregateRoot->getUncommittedEvents();
        $reconstitutedAggregateRoot = TestAggregateRoot::reconstituteFromHistory($history);
        $this->assertEquals('something else', $reconstitutedAggregateRoot->done);
        $this->assertCount(0, $reconstitutedAggregateRoot->getUncommittedEvents());
    }
}

class TestAggregateRoot extends EventSourcedAggregateRoot
{
    public $done = null;

    public static function create()
    {
        return new static;
    }

    public function getAggregateRootId() : string
    {
        return '809e7493-f998-4d4e-8520-0c90ab9ea57d';
    }

    public function doSomething()
    {
        $this->record(new SomethingWasDone);
    }

    public function doSomethingElse()
    {
        $this->record(new SomethingElseWasDone);
    }

    public function applySomethingWasDone()
    {
        $this->done = 'something';
    }

    public function applySomethingElseWasDone()
    {
        $this->done = 'something else';
    }
}

class SomethingWasDone
{}

class SomethingElseWasDone
{}
