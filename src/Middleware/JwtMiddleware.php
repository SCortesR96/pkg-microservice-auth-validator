<?php

namespace MyDevZone\Middleware;

use Closure;
use Exception;
use Illuminate\Http\{JsonResponse, Request};
use Firebase\JWT\{ExpiredException, JWT, Key};
use Symfony\Component\HttpFoundation\Response;

class JwtMiddleware
{
	public function handle(Request $request, Closure $next): Response
	{
		$token = $request->header('Authorization');
		if (!$token) {
			return response()->json(
				['error' => 'Token not provided'],
				JsonResponse::HTTP_UNAUTHORIZED
			);
		}

		try {
			$token = str_replace('Bearer ', '', $token);
			$decoded = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));

			// Pasar los datos decodificados a la request
			$request->attributes->set('jwt_data', $decoded);

			return $next($request);
		} catch (ExpiredException $e) {
			return response()->json(
				['error' => 'Token has expired'],
				JsonResponse::HTTP_UNAUTHORIZED
			);
		} catch (Exception $e) {
			return response()->json(
				['error' => 'Invalid token: ' . $e->getMessage()],
				JsonResponse::HTTP_INTERNAL_SERVER_ERROR
			);
		}
	}
}
