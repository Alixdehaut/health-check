<?php

declare(strict_types=1);

namespace Tseguier\HealthCheckBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Tseguier\HealthCheckBundle\HealthCheckInterface;

/**
 * @Route("/healthcheck")
 */
final class HealthCheckController
{
    /**
     * @var HealthCheckInterface
     */
    private $healthChecker;

    /**
     * @var string
     */
    private $dateFormat;

    public function __construct(HealthCheckInterface $healthChecker, string $dateFormat)
    {
        $this->dateFormat = $dateFormat;
        $this->healthChecker = $healthChecker;
    }

    /**
     * Get system health
     *
     * @Route("", methods={"GET"})
     *
     * @SWG\Get(
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response=200,
     *         description="Healthy system",
     *         @SWG\Schema(
     *             required={"status", "timestamp"},
     *             @SWG\Property(property="status", type="boolean"),
     *             @SWG\Property(property="timestamp", type="string")
     *         ),
     *     ),
     *     @SWG\Response(
     *         response=503,
     *         description="Unhealthy system",
     *         @SWG\Schema(
     *             required={"status", "timestamp"},
     *             @SWG\Property(property="status", type="boolean"),
     *             @SWG\Property(property="timestamp", type="string")
     *         ),
     *     ),
     * )
     */
    public function getHealth(): JsonResponse
    {
        $data = [
          'status' => $this->healthChecker->checkHealth()->getStatus(),
          'timestamp' => date($this->dateFormat),
        ];

        return new JsonResponse($data, $data['status'] ? 200 : 503);
    }
}
