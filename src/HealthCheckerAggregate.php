<?php

declare(strict_types=1);

namespace Tseguier\HealthCheckBundle;

use Tseguier\HealthCheckBundle\Dto\HealthData;

final class HealthCheckerAggregate implements HealthCheckInterface
{
    private $healthCheckers;

    public function __construct(iterable $healthCheckers)
    {
        $this->healthCheckers = $healthCheckers;
    }

    public function checkHealth(): HealthData
    {
        $status = true;
        foreach ($this->healthCheckers as $healthService) {
            $info = $healthService->checkHealth();
            if (true !== $info->getStatus()) {
                $status = false;
            }
        }

        return new HealthData($status);
    }

    private function retrieveHealthCheckerStatus(HealthCheckInterface $checker): bool
    {
        return $checker->getStatus();
    }
}
