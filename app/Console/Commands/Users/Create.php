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
  protected $signature = 'users:create {--email= : User email} {--password= : User password} {--name= : User name} {--is_admin= : Admin flag}';

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
  public function handle(): int
  {
    $email = $this->option('email');
    $password = $this->option('password');
    $name = $this->option('name');
    $is_admin = $this->option('is_admin');
    $user = User::create([
      'name' => $name,
      'password' => Hash::make($password),
      'email' => $email,
      'is_admin' => $is_admin
    ]);
    $this->line('Created user:');
    $this->line("\tUser id: <info>$user->id</info>");
    $this->line("\tUser name: <info>$name</info>");
    $this->line("\tUser password: <info>$password</info>");
    $this->line("\tUser email: <info>$email</info>");
    return 0;
  }
}
