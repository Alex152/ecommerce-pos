<?php

namespace App\Services;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSyncService
{
    public function syncPermissionsToRole(Role $role, array $permissions): void
    {
        $role->syncPermissions($permissions);
    }

    public function createRoleWithPermissions(string $roleName, array $permissions): Role
    {
        $role = Role::create(['name' => $roleName]);
        $this->syncPermissionsToRole($role, $permissions);
        return $role;
    }
}