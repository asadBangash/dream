<?php

namespace Modules\MainApp\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class MainAppDatabaseSeeder extends Seeder
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
        $this->call(FAQSeeder::class);
        $this->call(FeatureSeeder::class);
        $this->call(FlagIconSeeder::class);
        $this->call(LanguageSeeder::class);
        $this->call(PackageSeeder::class);
        $this->call(SectionsSeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(TestimonialSeeder::class);

        $this->call(UserSeeder::class);
    }
}
