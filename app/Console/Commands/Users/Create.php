<?php

namespace App\Console\Commands\Users;

use App\User;
use Hash;
use Illuminate\Console\Command;

class Create extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:create {--email= : User email} {--password= : User password} {--name= : User name} {--is_admin= : Admin flag} {--is_moderate= : Moderate flag}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $email = $this->option('email');
        $password = $this->option('password');
        $name = $this->option('name');
        $is_admin = $this->option('is_admin') ?? false;
        $is_moderate = $this->option('is_moderate') ?? false;
        $user = User::create([
            'name' => $name,
            'password' => Hash::make($password),
            'email' => $email,
            'is_admin' => $is_admin,
            'is_moderate' => $is_moderate,
        ]);
        $this->line('Created user:');
        $this->line("\tUser id: <info>$user->id</info>");
        $this->line("\tUser name: <info>$name</info>");
        $this->line("\tUser password: <info>$password</info>");
        $this->line("\tUser email: <info>$email</info>");

        return 0;
    }
}
