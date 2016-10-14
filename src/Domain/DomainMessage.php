<?php
namespace Hlgrrnhrdt\Eventable\Domain;

use DateTimeImmutable;

/**
 * DomainMessage
 *
 * @author Holger Reinhardt <holger.reinhardt@aboutyou.de>
 */
class DomainMessage
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var int
     */
    private $playhead;

    /**
     * @var mixed
     */
    private $payload;

    /**
     * @var DateTimeImmutable
     */
    private $recordedOn;

    /**
     * DomainMessage constructor.
     *
     * @param string            $id
     * @param int               $playhead
     * @param mixed             $payload
     * @param DateTimeImmutable $recordedOn
     */
    public function __construct(string $id, int $playhead, $payload, DateTimeImmutable $recordedOn)
    {
        $this->id = $id;
        $this->playhead = $playhead;
        $this->payload = $payload;
        $this->recordedOn = $recordedOn;
    }

    /**
     * @param string $id
     * @param int    $playhead
     * @param        $event
     *
     * @return static
     */
    public static function record(string $id, int $playhead, $event)
    {
        return new static($id, $playhead, $event, new DateTimeImmutable());
    }

    /**
     * @return string
     */
    public function getId() : string
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getPlayhead() : int
    {
        return $this->playhead;
    }

    /**
     * @return mixed
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getRecordedOn() : DateTimeImmutable
    {
        return $this->recordedOn;
    }
}
