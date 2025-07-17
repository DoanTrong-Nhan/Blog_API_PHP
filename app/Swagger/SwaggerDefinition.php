<?php

namespace App\Swagger;

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         version="1.0.0",
 *         title="Blog API",
 *         description="Tài liệu API cho ứng dụng Blog viết bằng Laravel",
 *         @OA\Contact(
 *             name="Nhân Tác",
 *             email="email@example.com"
 *         )
 *     )
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
class SwaggerDefinition {}
