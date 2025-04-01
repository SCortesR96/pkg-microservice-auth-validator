<?php

namespace MyDevZone\Traits;

use Illuminate\Http\Request;
use Firebase\JWT\{JWT, Key};
use Illuminate\Http\JsonResponse;

trait DecodeToken
{
	public function decode(Request $request)
	{
		$token = $request->bearerToken();

		if (!$token) {
			return response()->json(['error' => 'Token not provided'], JsonResponse::HTTP_UNAUTHORIZED);
		}

		try {
			return JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
		} catch (\Exception $e) {
			return response()->json(['error' => 'Invalid Token'], JsonResponse::HTTP_UNAUTHORIZED);
		}
	}
}
