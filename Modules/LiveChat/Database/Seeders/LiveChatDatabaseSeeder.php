<?php

namespace Modules\LiveChat\Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class LiveChatDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Modules\CMS\Entities\ImageGallery::create([
            'title' => 'live_chat',
            'slug' => Str::slug('live_chat'),
            'status_id' => 1,
        ]);
    }
}
