<?php

namespace Modules\Forums\Database\Seeders;

use App\Enums\Status;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Modules\Forums\Entities\ForumPost;


class ForumPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Generate 50 forum posts
        for ($i = 0; $i < 50; $i++) {
            ForumPost::create([
                'slug' => Str::slug($faker->sentence),
                'target_roles' => rand(1, 5),
                'description' => $faker->paragraph,
                'upload_id' =>null, // Assuming you have some uploads in the uploads table
                'status' => Status::ACTIVE, // Assuming Status::ACTIVE is constant in your app
                'is_published' => 1,
                'approved_by' => 1, // Assuming you have approvers (users)
                'created_by' => 1,
                'published_by' => 1, // Assuming you have some users in users table
                'published_at' => $faker->optional()->dateTime,
            ]);
        }
    }
}
