<?php

namespace Database\Seeders\Library;

use App\Models\Library\BookCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'History',
            'Poyem',
            'Science',
            'Arch',
            'Tour'
        ];

        foreach ($categories as $category){
            $row = new BookCategory ();
            $row->name = $category;
            $row->save ();
        }
    }
}
