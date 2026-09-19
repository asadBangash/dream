<?php

namespace Database\Seeders;

use Database\Seeders\Demo\BranchDemoSeeder;
use Database\Seeders\Demo\DemoAcademicSeeder;
use Database\Seeders\Demo\DemoAttendanceSeeder;
use Database\Seeders\Demo\DemoCertificateSeeder;
use Database\Seeders\Demo\DemoExaminationSeeder;
use Database\Seeders\Demo\DemoOrganizationSeeder;
use Database\Seeders\Demo\DemoPeopleSeeder;
use Database\Seeders\Demo\DemoUserSeeder;
use Database\Seeders\WebsiteSetup\AboutSeeder;
use Database\Seeders\WebsiteSetup\ContactInfoSeeder;
use Database\Seeders\WebsiteSetup\CounterSeeder;
use Database\Seeders\WebsiteSetup\DepartmentContactSeeder;
use Database\Seeders\WebsiteSetup\GalleryCategorySeeder;
use Database\Seeders\WebsiteSetup\GallerySeeder;
use Database\Seeders\WebsiteSetup\NewsSeeder;
use Database\Seeders\WebsiteSetup\PageSeeder;
use Database\Seeders\WebsiteSetup\PageSectionsSeeder;
use Database\Seeders\WebsiteSetup\SliderSeeder;
use Illuminate\Database\Seeder;

class DreamTuitionDemoSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UploadSeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,
            FlagIconSeeder::class,
            LanguageSeeder::class,
            SettingSeeder::class,
            SearchSeeder::class,
            GenderSeeder::class,
            ReligionSeeder::class,
            BloodGroupSeeder::class,
            SessionSeeder::class,
            SubscriptionSeeder::class,
            CurrencySeeder::class,
            PageSectionsSeeder::class,
            SliderSeeder::class,
            CounterSeeder::class,
            NewsSeeder::class,
            GalleryCategorySeeder::class,
            GallerySeeder::class,
            ContactInfoSeeder::class,
            DepartmentContactSeeder::class,
            AboutSeeder::class,
            PageSeeder::class,
            BranchDemoSeeder::class,
            DemoUserSeeder::class,
            DemoOrganizationSeeder::class,
            DemoAcademicSeeder::class,
            DemoPeopleSeeder::class,
            DemoExaminationSeeder::class,
            DemoAttendanceSeeder::class,
            DemoCertificateSeeder::class,
        ]);
    }
}
