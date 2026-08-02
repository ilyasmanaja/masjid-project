<?php
namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class MakePanelUser extends Command
{
    protected $signature = 'make:panel-user';
    protected $description = 'Membuat user baru untuk panel dengan username';

    public function handle()
    {
        $name = $this->ask('Name');
        $username = $this->ask('Username');
        $email = $this->ask('Email address');
        $password = $this->secret('Password');

        User::create([
            'name' => $name,
            'username' => $username,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info("User {$username} berhasil dibuat!");
    }
}