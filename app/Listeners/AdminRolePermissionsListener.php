<?php

namespace App\Listeners;

use App\Events\PermissionChangeEvent;
use App\Services\System\RolesService;

class AdminRolePermissionsListener
{
    protected $service;

    public function __construct(RolesService $service)
    {
        $this->service = $service;
    }

    public function handle(PermissionChangeEvent $event)
    {
        //todo have to modify that change by type
        if ($event->action === 'created') {
            $this->service->syncAdminRolePermissions();
        }

        if ($event->action === 'updated') {

        }

        if ($event->action === 'deleted') {

        }
    }
}
