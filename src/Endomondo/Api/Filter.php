<?php

namespace E2S\Endomondo\Api;

final class Filter
{
    /** @var Sport */
    private $sport;

    /** @var \DateTime */
    private $from;

    /** @var \DateTime */
    private $to;

    /**
     * @param Sport $sport
     * @param \DateTime $from
     * @param \DateTime $to
     */
    public function __construct(Sport $sport = null, \DateTime $from = null, \DateTime $to = null)
    {
        $this->sport = $sport;
        $this->from = $from;
        if ($this->from) {
            $this->from->setTimezone(new \DateTimeZone('UTC'));
        }

        $this->to = $to;
        if ($this->to) {
            $this->to->setTimezone(new \DateTimeZone('UTC'));
        }
    }

    /**
     * @return Sport|null
     */
    public function sport()
    {
        return $this->sport;
    }

    /**
     * @return \DateTime|null
     */
    public function from()
    {
        return $this->from;
    }

    /**
     * @return \DateTime|null
     */
    public function to()
    {
        return $this->to;
    }

    public function withSport(Sport $sport): Filter
    {
        return new self($sport, $this->from, $this->to);
    }

    public function withFrom(\DateTime $from): Filter
    {
        return new self($this->sport, $from, $this->to);
    }

    public function withTo(\DateTime $to): Filter
    {
        return new self($this->sport, $this->from, $to);
    }

    public function toQueryParams(): array
    {
        $params = [];
        if ($this->sport) {
            $params['sport'] = (string)$this->sport;
        }

        if ($this->from) {
            $params['after'] = $this->from->format('Y-m-d\TH:i:s.v\Z');
        }

        if ($this->to) {
            $params['before'] = $this->to->format('Y-m-d\TH:i:s.v\Z');
        }

        return $params;
    }
}