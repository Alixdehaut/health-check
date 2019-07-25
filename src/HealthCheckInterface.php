<?php

namespace Tseguier\HealthCheckBundle;

use Tseguier\HealthCheckBundle\Dto\HealthData;

interface HealthCheckInterface
{
    public const TAG = 'health_checker.service';

    public function checkHealth(): HealthData;
}
