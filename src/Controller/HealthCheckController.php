<?php

namespace Tseguier\HealthCheckBundle\Controller;

use Tseguier\HealthCheckBundle\HealthCheckInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;

/**
 * @Route("/healthcheck")
 */
class HealthCheckController
{
    private $healthCheckers = [];

    private $dateFormat;

    public function __construct(iterable $healthCheckers, string $dateFormat)
    {
        $this->dateFormat = $dateFormat;
        $this->healthCheckers = $healthCheckers;
    }

    /**
       * Get paginated country configurations.
       *
       * @Route("", methods={"GET"})
       *
       * @SWG\Response(
       *     response=200,
       *     description="Healthy system",
       *     schema=@SWG\Schema(type="object",
       *          @SWG\Property(property="data", @SWG\Items(
       *              @SWG\Property(property="status", type="boolean"),
       *              @SWG\Property(property="timestamp", type="string", example="countries"),
       *          ))
       *    )
       * )
       * @SWG\Response(
       *     response=500,
       *     description="Unhealthy system",
       *     schema=@SWG\Schema(type="object",
       *          @SWG\Property(property="data", @SWG\Items(
       *              @SWG\Property(property="status", type="boolean"),
       *              @SWG\Property(property="timestamp", type="string", example="countries"),
       *          ))
       *    )
       * )
       *
       *
       */
    public function getHealth(): JsonResponse
    {
        $data = [
          'status' => true,
          'timestamp' => date($this->dateFormat),
        ];

        foreach ($this->healthCheckers as $healthService) {
            $info = $healthService->checkHealth();
            if (!$info->getStatus()) {
                $data['status'] = false;
            }
        }

        return new JsonResponse($data, $data['status'] ? 200 : 503);
    }
}
