<?php

namespace App\Events;

use Spatie\Permission\Models\Permission;

class PermissionChangeEvent
{
    public $permission;
    public $action;

    public function __construct(Permission $permission, string $action)
    {
        $this->permission = $permission;
        $this->action = $action;
    }
}
