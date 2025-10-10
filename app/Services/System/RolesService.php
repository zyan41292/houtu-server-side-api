<?php

namespace App\Services\System;

use App\Models\Admin;
use App\Models\Role;
use App\Services\BaseService;
use Spatie\Permission\Models\Permission;

class RolesService extends BaseService
{
    public function __construct(Role $role)
    {
        parent::__construct($role);
    }

    public function list()
    {
        $roles = $this->model->with('permissions')->get();

        $roles = $roles->map(function ($role) {
            return [
                'id' => $role->id,
                'name' => $role->name,
                'status' => $role->status ?? 0,
                'permissions' => $role->permissions->pluck('id')->toArray(), // 只保留权限 ID
            ];
        });

        return [
            'items' => $roles
        ];
    }

    public function store($data)
    {
        return \DB::transaction(function () use ($data) {
            $role = $this->model->create($data);

            // if data has permissionIds, sync permissions
            if (!empty($data['permissionIds']) && is_array($data['permissionIds'])) {
                $permissions = \Spatie\Permission\Models\Permission::whereIn('id', $data['permissionIds'])->get();
                $role->syncPermissions($permissions);
            }
            //clear cache
            app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
            return [
                'id' => $role->id,
                'name' => $role->name,
                'status' => $role->status ?? 0,
                'permissions' => $role->permissions->pluck('id')->toArray(),
            ];
        });
    }

    public function update($id, $data)
    {
        return \DB::transaction(function () use ($id, $data) {
            $role = $this->findOrFail($id);

            $role->update($data);

            // if data has permissionIds, sync permissions
            if (!empty($data['permissionIds']) && is_array($data['permissionIds'])) {
                $permissions = \Spatie\Permission\Models\Permission::whereIn('id', $data['permissionIds'])
                    ->where('guard_name', $role->guard_name ?? 'api') // 保持 guard 一致
                    ->get();
                $role->syncPermissions($permissions);
            }

            // clear cache
            app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

            return [
                'id' => $role->id,
                'name' => $role->name,
                'status' => $role->status ?? 0,
                'permissions' => $role->permissions->pluck('id')->toArray(),
            ];
        });
    }

    public function destroy($id)
    {
        $role = $this->findOrFail($id);
        return $role->delete();
    }


    /**
     * 获取或创建超级管理员角色
     */
    public function getOrCreateAdminRole(): Role
    {
        return Role::firstOrCreate(
            ['name' => 'admin', 'guard_name' => 'api']
        );
    }

    /**
     * 同步超级管理员角色权限（保持与数据库权限一致）
     */
    public function syncAdminRolePermissions(): Role
    {
        return \DB::transaction(function () {
            $adminRole = $this->getOrCreateAdminRole();

            $allPermissions = Permission::all();
            $adminRole->syncPermissions($allPermissions);

            // 刷新缓存
            app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

            return $adminRole;
        });
    }

    /**
     * 给指定用户分配超级管理员角色
     */
    public function assignSuperRoleToUser(int $adminId): void
    {
        $adminRole = $this->syncAdminRolePermissions();
        $admin = Admin::findOrFail($adminId);
        $admin->assignRole($adminRole);
    }

}
