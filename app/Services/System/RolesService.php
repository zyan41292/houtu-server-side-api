<?php

namespace App\Services\System;

use App\Models\Role;
use App\Services\BaseService;

class RolesService extends BaseService
{
    public function __construct(Role $role)
    {
        parent::__construct($role);
    }

    public function update($id, $data)
    {
        $role = $this->findOrFail($id);

        return $role->update($data);
    }

    public function destroy($id)
    {
        $role = $this->findOrFail($id);
        return $role->delete();
    }
}
