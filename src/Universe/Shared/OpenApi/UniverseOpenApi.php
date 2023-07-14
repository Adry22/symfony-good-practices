<?php
declare(strict_types=1);

namespace Universe\Shared\OpenApi;

use OpenApi\Annotations as OA;

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         version="1.0.0",
 *         title="Universe Web Api"
 *     ),
 *     @OA\Server(
 *         description="Development",
 *         url="http://localhost:9000"
 *     )
 * )
 */
final class UniverseOpenApi
{
}
