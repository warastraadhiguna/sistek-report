<?php

namespace App\Helpers;

use App\Models\Role;
use App\Models\Resource;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;

class PermissionHelper
{
    public static function check(string $resourceName, string $permission): bool
    {
        $user = Auth::user();
        if (!$user) {
            return false;
        }

        // ✅ Cari ID dari resource berdasarkan nama
        $resource = Resource::where('name', $resourceName)->first();
        if (!$resource) {
            return false;
        }

        // ✅ Cek izin di tabel `permissions`
        return Permission::where('resource_id', $resource->id)
            ->where('role_id', $user->role_id)
            ->where($permission, true)
            ->exists();
    }
}