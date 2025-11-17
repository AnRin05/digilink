<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'create:admin {email} {password} {name?}';
    protected $description = 'Create a new admin user account';

    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');
        $name = $this->argument('name') ?? 'Admin';

        if (Admin::where('email', $email)->exists()) {
            $this->error('An admin with this email already exists.');
            return 1;
        }

        Admin::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info("Admin user '{$email}' created successfully!");
        return 0;
    }
}