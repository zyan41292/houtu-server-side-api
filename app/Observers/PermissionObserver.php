<?php

namespace App\Observers;

use App\Events\PermissionChangeEvent;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Log;
class PermissionObserver
{
    public function created(Permission $permission)
    {
        Log::info("权限新增：" . $permission->name);
        event(new PermissionChangeEvent($permission, 'created'));
    }

    public function updated(Permission $permission)
    {
        Log::info("权限更新：" . $permission->name);
    }

    public function deleted(Permission $permission)
    {
        Log::info("权限删除：" . $permission->name);
    }
}
