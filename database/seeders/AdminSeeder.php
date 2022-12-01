<?php

namespace Database\Seeders;
use Hash;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => "Super Admin",
            'username' => "Admin",
            'firstname' => "Super",
            'lastname' => "Admin",
            'email' => "Admin@admin.com",
            'phone' => "03211234567",
            'department' => "Administrator",
            'designation' => "Admin",
            'password' => Hash::make("12345678"),
        ]);
    }
}
