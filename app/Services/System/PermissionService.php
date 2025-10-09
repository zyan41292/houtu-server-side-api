<?php

namespace App\Services\System;

use App\Services\BaseService;
use Spatie\Permission\Models\Permission;

class PermissionService extends BaseService
{
    public function __construct(Permission $permission)
    {
        parent::__construct($permission);
    }


}
