<?php

namespace App\Console\Commands\Users;

use App\User;
use Illuminate\Console\Command;

class Create extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:create {--email= : User email} {--password= : User password} {--name= : User name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $email = $this->option('email');
        $password = $this->option('password');
        $name = $this->option('name');
        $user = User::create([
            'name' => $name,
            'password' => \Hash::make($password),
            'email' => $email
        ]);
        $this->line('Created user:');
        $this->line("\tUser id: <info>$user->id</info>");
        $this->line("\tUser name: <info>$name</info>");
        $this->line("\tUser password: <info>$password</info>");
        $this->line("\tUser email: <info>$email</info>");
        return 0;
    }
}
