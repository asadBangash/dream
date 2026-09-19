<?php

namespace Modules\MainApp\Database\Seeders;

use App\Models\Upload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Modules\MainApp\Entities\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");
        Upload::create([
            'path' => 'backend/uploads/users/user.png',
        ]);

        $schoolName = env('APP_NAME', 'School');
        $domain     = env('APP_DOMAIN', 'school.com');

        User::create([
            'name'              => 'Super Admin',
            'phone'             => '+92 300 1234567',
            'email'             => 'superadmin@' . $domain,
            'email_verified_at' => now(),
            'password'          => Hash::make(123456),
            'remember_token'    => Str::random(10),
            'date_of_birth'     => '2022-09-07',
            'upload_id'         => 1,
        ]);
    }
}