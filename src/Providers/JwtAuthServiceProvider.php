<?php

namespace MyDevZone\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use MyDevZone\Middleware\{JwtMiddleware, PermissionMiddleware};

class JwtAuthServiceProvider extends ServiceProvider
{
	public function boot()
	{
		$router = $this->app->make(Router::class);
		$router->aliasMiddleware('jwt.verify', JwtMiddleware::class);
		$router->aliasMiddleware('permission', PermissionMiddleware::class);
	}

	public function register()
	{
		//
	}
}
