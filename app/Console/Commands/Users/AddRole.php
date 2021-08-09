<?php

namespace App\Console\Commands\Users;

use App\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class AddRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:add_role {user} {role}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add role to user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $argumentUser = $this->argument('user');
        $role = $this->argument('role');

        if (!Role::findByName($role)->exists) {
            $this->info("Role {$role} not found!");
            return 0;
        }

        if ($user = User::where('email', $argumentUser)->orWhere('id', $argumentUser)->first()) {
            $user->assignRole($role);
        } else {
            $this->info("User {$user} not found!");
            return 0;
        }
    }
}
