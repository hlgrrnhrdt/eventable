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
    public function it_has_getters()
    {
        $message = DomainMessage::record('id', 42, 'payload');
    }
}
