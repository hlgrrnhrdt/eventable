<?php
namespace Hlgrrnhrdt\Test\Eventable\Domain;

use Hlgrrnhrdt\Eventable\Domain\DomainMessage;
use Hlgrrnhrdt\Eventable\Test\TestCase;

/**
 * DomainMessageTest
 *
 * @author Holger Reinhardt <holger.reinhardt@aboutyou.de>
 */
class DomainMessageTest extends TestCase
{
    /**
     *
     */
    public function test_it_has_getters()
    {
        $message = DomainMessage::record('id', 42, 'payload');

        $this->assertEquals('id', $message->getId());
        $this->assertEquals(42, $message->getPlayhead());
        $this->assertEquals('payload', $message->getPayload());
    }
}
