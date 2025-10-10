<?php

namespace App\Services\System;

use App\Models\Menu;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class MenuService extends BaseService
{
    public function __construct(Menu $menu)
    {
        parent::__construct($menu);
    }

    public function store($data)
    {
        return DB::transaction(function () use ($data) {
            if (empty($data['permission_id']) && !empty($data['name'])) {
                $permission = Permission::firstOrCreate([
                    'name' => 'menu.' . Str::slug($data['name'])
                ]);
                $data['permission_id'] = $permission->id;
            }
            return $this->create($data);
        });
    }

    public function update($id, $data)
    {
        $update = $this->findOrFail($id);
        return $update->update($data);
    }

    public function destroy($id)
    {
        return DB::transaction(function () use ($id) {
            $menu = $this->findOrFail($id);
            $permissionId = $menu->permission_id;
            $menu->delete();
            if ($permissionId) {
                $permission = Permission::find($permissionId);
                if ($permission) {
                    $permission->delete();
                }
            }
            return true;
        });
    }
}
