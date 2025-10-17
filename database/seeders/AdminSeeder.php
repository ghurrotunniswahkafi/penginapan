<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // admins table
        $admin = Admin::firstOrNew(['email' => 'admin@example.com']);
        $admin->name = 'Administrator';
        $admin->password = Hash::make('password123'); // login: admin@example.com / password123
        $admin->save();

        // users table - ensure role set to 'admin'
        $user = User::firstOrNew(['email' => 'admin@example.com']);
        $user->name = 'Administrator';
        $user->password = Hash::make('password123');
        $user->role = 'admin';
        $user->save();
    }
}
