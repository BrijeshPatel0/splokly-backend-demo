<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @OA\Post(
 *     path="/api/auth/register",
 *     summary="Register Users",
 *     tags={"Authentification"},
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="name", type="string", example="Bogdan"),
 *                     @OA\Property(property="email", type="string", example="bogdan.vetrov@gmail.com"),
 *                     @OA\Property(property="password", type="string", example="tetspassword/23"),
 *                     @OA\Property(property="role", type="string", example="student"),
 *                 )
 *             },
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Created User object",
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="Bogdan"),
 *             @OA\Property(property="email", type="string", example="bogdan.vetrov@gmail.com"),
 *             @OA\Property(property="id", type="int", example="9"),
 *             @OA\Property(property="roles", type="string", example="[]"),
 *         ),
 *     ),
 * ),
 * @OA\Post(
 *     path="/api/auth/login",
 *     summary="Login Users",
 *     tags={"Authentification"},
 *
 *     @OA\RequestBody(
 *         @OA\JsonContent(
 *             allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="email", type="string", example="bogdan.vetrov@gmail.com"),
 *                     @OA\Property(property="password", type="string", example="tetspassword/23"),
 *                 )
 *             },
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Loged in User object and Created API Token",
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="Bogdan"),
 *             @OA\Property(property="email", type="string", example="bogdan.vetrov@gmail.com"),
 *             @OA\Property(property="id", type="int", example="9"),
 *             @OA\Property(property="token", type="string", example="25|m6LGpi9bKh6sV3ofjXDWWoyjS1yfqPhhTZZN9mJO"),
 *         ),
 *     ),
 * ),
 */
class UserAuthentificationController extends Controller
{
    //
}
