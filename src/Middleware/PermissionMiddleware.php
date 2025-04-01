<?php

namespace MyDevZone\Middleware;

use Closure;
use Illuminate\Http\Request;
use MyDevZone\Traits\ValidatePermission;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
	use ValidatePermission;

	public function handle(Request $request, Closure $next, string $permission): Response
	{
		if ($this->ensurePermission($request, $permission)) {
			return $next($request);
		}
		return response()->json(['message' => 'Unauthorized'], Response::HTTP_FORBIDDEN);
	}
}
