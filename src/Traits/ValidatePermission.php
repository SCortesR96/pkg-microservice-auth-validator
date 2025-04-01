<?php

namespace MyDevZone\Traits;

use Illuminate\Http\Request;

trait ValidatePermission
{
	use DecodeToken;

	public function getPermissions(Request $request)
	{
		$data = $this->decode($request);
		return $data->auth ?? null;
	}

	public function hasPermission(Request $request, string $permission): bool
	{
		$data = $this->getPermissions($request);
		return isset($data->permissions) && (in_array($permission, $data->permissions) || in_array('super_admin', $data->roles));
	}

	public function ensurePermission(Request $request, string $permission): bool
	{
		return $this->hasPermission($request, $permission);
	}
}
