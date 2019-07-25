<?php

namespace Tseguier\HealthCheckBundle\Dto;

class HealthData
{
    private $status;

    public function __construct(bool $status)
    {
        $this->status = $status;
    }

    public function setStatus(bool $status)
    {
        $this->status = $status;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }
}
