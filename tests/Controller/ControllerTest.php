<?php

namespace HealthCheckTest\Controller;

use PHPUnit\Framework\TestCase;
use Tseguier\HealthCheckBundle\Controller\HealthCheckController;
use Tseguier\HealthCheckBundle\Dto\HealthData;

class SuccessfulChecker {
    public function checkHealth()
    {
      return new HealthData(true);
    }
}

class FailfulChecker {
    public function checkHealth()
    {
      return new HealthData(false);
    }
}

class ControllerTest extends TestCase
{
    public function testSuccess()
    {
        $checker = new SuccessfulChecker();
        $controller = new HealthCheckController([$checker], 'Y-m-d H:i:s T');
        $result = $controller->getHealth();
        $body = json_decode($result->getContent());

        $this->assertEquals($result->getStatusCode(), 200);
        $this->assertEquals($body->status, true);

    }

    public function testFail()
    {
        $checker = new FailfulChecker();
        $controller = new HealthCheckController([$checker], 'Y-m-d H:i:s T');
        $result = $controller->getHealth();
        $body = json_decode($result->getContent());

        $this->assertEquals($result->getStatusCode(), 503);
        $this->assertEquals($body->status, false);

    }
}
