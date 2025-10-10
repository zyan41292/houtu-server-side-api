<?php

namespace App\Console\Commands;

use App\Services\System\RolesService;
use Illuminate\Console\Command;

class AssignSuperRoleToUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:assign-super-role-to-user {userId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command Assign Super Role To User';

    private $rolesService;

    public function __construct(RolesService $rolesService)
    {
        parent::__construct();
        $this->rolesService = $rolesService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->argument('userId');
        $this->rolesService->assignSuperRoleToUser($userId);
        $this->info('Super Role Assigned Successfully');
    }
}
