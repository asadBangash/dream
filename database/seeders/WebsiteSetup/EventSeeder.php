<?php

namespace Database\Seeders\WebsiteSetup;

use App\Models\Event;
use App\Models\EventTranslate;
use App\Models\Upload;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $titels = [
            'Meet the Teacher',
            'Trunk or Treat',
            'Family Feast',
            'Camp Read Away ',
            'Winter Art Contest',
            'Holidays Around the World',
            'Graduation Celebration',
            'Pie a Teacher',
            'Career Day',
            'Teacher vs. Student Competition'
        ];

        $bn_titels = [
            'শিক্ষকের সাথে দেখা করুন',
             'ট্রাঙ্ক বা ট্রিট',
             'পারিবারিক উৎসব',
             'ক্যাম্প পড়ুন',
             'শীতকালীন আর্ট কনটেস্ট',
             'বিশ্ব জুড়ে ছুটি',
             'গ্রাজুয়েশন সেলিব্রেশন',
             'পাই এ টিচার',
             'পেশা দিবস',
             'শিক্ষক বনাম ছাত্র প্রতিযোগিতা'
        ];

        $descriptions = [
            'A classic and fan favorite! In the cafeteria or auditorium, each grade level sets up a table to meet and greet their upcoming students and families. The tables can be decorated and small gifts such as pencils or snacks can be passed out. This is a great way for teachers to make a great first impression and for students to be less inclined to get those first day of school jitters.',

            'Happening the week of Halloween, this can be a great alternative to a typical party and also allows students to celebrate outside of standard trick or treating (which we all know can be disastrous if landing on a school night). Parents and volunteers decorate the trunks of their cars and park in a circle around the parking lot. At the end of the day, students walk from car to car and collect candy and other treats. This is a great opportunity for members of the community to get involved and spend a little extra time with their kids! ',

            'This typically falls the week before Thanksgiving Break and is a great opportunity for families to join their children and teachers for a gratitude-centered meal. The feast can be donated from the community, made in-house, or a potluck depending on your school community! If you are looking for an easy way to get parents more involved in your classroom or school in general, this is the perfect place to start. ',

            'Searching for a way to bring the great outdoors into the four walls of your classroom? This may be it! Teachers ask families to send in sheets, blankets, and flashlights. In partners, students work to create the best reading fort they can imagine. Then, lights out! For the rest of the time, students flashlight read independently or with a buddy. S’mores and other campfire friendly snacks can be provided as well, but are not necessary to make this a fun and exciting experience.',

            'This is a great event for either the whole school or individual grade levels that have multiple classrooms. Teachers decide on a winter themed muse and have students create their own interpretation of it. Once all artwork is complete, students submit their masterpieces for voting. In order to make it fair, different grade levels or classrooms would vote on each others’ to avoid favoritism and give everyone a fair shot! Categories for voting could include most unique, most creative, the cutest, etc. and the winners could receive a virtual prize. ',

            'This event is best held by individual grade levels to ensure there is adequate time in the schedule to fully enjoy the experience. Every classroom on a grade level picks a country that has a unique holiday tradition or celebration. Examples include Israel, Germany, England, Mexico, etc. The teacher in charge of each country plans a quick read-a-loud or video to teach the students about the tradition and its importance, as well as a craft activity. The students then spend the day rotating to each country to learn and experience cultures and fun traditions unlike their own. ',

            'Celebrated each year on March 2nd, Read Across America Day was first established as a way to celebrate Dr. Suess’s birthday. Today, its main purpose is to motivate and help children become aware and celebrate good reading habits. Students from similar or different classrooms and grade levels are partnered up to buddy read and share in their love of reading. ',

            'This is a take on the classic field day event that students across all grade levels typically participate in each year. Instead of the average activities such as a cakewalk or relay race, students are challenged across all areas of STEM! This event could include activities such as a paper plate marble race, clothespin geometry, paper airplane challenge, or an array of engineering building challenges. The opportunities are endless and this event will get your kids involved in the many aspects of STEM-based fun.',

            'Elementary and Middle Schools arrange with their affiliate or nearby high school an event where soon-to-be graduates visit the school and take part in a parade. The graduates wear their gowns or college apparel and stroll through the music-filled hallways to be celebrated as well as get younger students thinking and excited about their own futures. Students lining the hallways are encouraged to wear apparel from their favorite university and cheer as the graduates parade through.',

            'This event is the perfect class or school wide incentive, especially if they have a favorite teacher they would like to surprise with a splat! Once classes or grade levels reach their predetermined goal, a teacher is selected to get pied in the face in front of the whole student body. Maybe not the most fun for the targeted teacher, but a memorable experience for everyone else! '
        ];

        $bn_descriptions = [
            'একটি ক্লাসিক এবং ফ্যান প্রিয়! ক্যাফেটেরিয়া বা অডিটোরিয়ামে, প্রতিটি গ্রেড স্তর তাদের আসন্ন ছাত্র এবং পরিবারের সাথে দেখা করার জন্য একটি টেবিল সেট করে। টেবিলগুলি সজ্জিত করা যেতে পারে এবং ছোট উপহার যেমন পেন্সিল বা স্ন্যাকস দিয়ে দেওয়া যেতে পারে। এটি শিক্ষকদের জন্য একটি দুর্দান্ত প্রথম ছাপ তৈরি করার একটি দুর্দান্ত উপায় এবং শিক্ষার্থীদের জন্য স্কুলের প্রথম দিনটির ঝাঁকুনি পেতে কম ঝোঁক।',

             'হ্যালোউইনের সপ্তাহে, এটি একটি সাধারণ পার্টির জন্য একটি দুর্দান্ত বিকল্প হতে পারে এবং এটি শিক্ষার্থীদের স্ট্যান্ডার্ড ট্রিক বা চিকিত্সার বাইরে উদযাপন করতে দেয় (যা আমরা সবাই জানি স্কুলের রাতে অবতরণ করলে বিপর্যয়কর হতে পারে)। পিতামাতা এবং স্বেচ্ছাসেবকরা তাদের গাড়ির ট্রাঙ্কগুলি সাজান এবং পার্কিং লটের চারপাশে একটি বৃত্তে পার্ক করেন। দিনের শেষে, শিক্ষার্থীরা গাড়ি থেকে গাড়িতে হেঁটে মিছরি এবং অন্যান্য খাবার সংগ্রহ করে। সম্প্রদায়ের সদস্যদের জড়িত হওয়ার এবং তাদের বাচ্চাদের সাথে একটু অতিরিক্ত সময় কাটানোর জন্য এটি একটি দুর্দান্ত সুযোগ! ',

             'এটি সাধারণত থ্যাঙ্কসগিভিং বিরতির এক সপ্তাহ আগে পড়ে এবং পরিবারের জন্য তাদের সন্তানদের এবং শিক্ষকদের সাথে কৃতজ্ঞতা-কেন্দ্রিক খাবারের জন্য যোগদান করার একটি দুর্দান্ত সুযোগ। ভোজন সম্প্রদায় থেকে দান করা যেতে পারে, ঘরে তৈরি করা যেতে পারে বা আপনার স্কুল সম্প্রদায়ের উপর নির্ভর করে একটি পটলাক! আপনি যদি সাধারণভাবে আপনার শ্রেণীকক্ষ বা স্কুলে অভিভাবকদের আরও জড়িত করার একটি সহজ উপায় খুঁজছেন, তাহলে এটি শুরু করার উপযুক্ত জায়গা। ',

             'আপনার শ্রেণীকক্ষের চার দেওয়ালে দুর্দান্ত বহিরঙ্গন আনার উপায় খুঁজছেন? এটা হতে পারে! শিক্ষকরা পরিবারকে চাদর, কম্বল এবং ফ্ল্যাশলাইট পাঠাতে বলেন। অংশীদারদের মধ্যে, শিক্ষার্থীরা তাদের কল্পনা করতে পারে এমন সেরা পড়ার দুর্গ তৈরি করতে কাজ করে। তারপর, আলো নিভে! বাকি সময়ের জন্য, শিক্ষার্থীরা ফ্ল্যাশলাইট স্বাধীনভাবে বা বন্ধুর সাথে পড়ে। S’mores এবং অন্যান্য ক্যাম্পফায়ার বন্ধুত্বপূর্ণ স্ন্যাকসও প্রদান করা যেতে পারে, তবে এটি একটি মজাদার এবং উত্তেজনাপূর্ণ অভিজ্ঞতা করার জন্য প্রয়োজনীয় নয়।',

             'এটি হয় পুরো স্কুল বা স্বতন্ত্র গ্রেড স্তরের জন্য একটি দুর্দান্ত ইভেন্ট যার একাধিক শ্রেণীকক্ষ রয়েছে৷ শিক্ষকরা একটি শীতকালীন থিমযুক্ত যাদুঘরের বিষয়ে সিদ্ধান্ত নেন এবং শিক্ষার্থীদের এটির নিজস্ব ব্যাখ্যা তৈরি করতে দেন। সমস্ত আর্টওয়ার্ক সম্পূর্ণ হয়ে গেলে, ছাত্ররা ভোট দেওয়ার জন্য তাদের মাস্টারপিস জমা দেয়। এটিকে ন্যায্য করার জন্য, বিভিন্ন গ্রেড স্তর বা শ্রেণীকক্ষ পক্ষপাত এড়াতে একে অপরকে ভোট দেবে এবং প্রত্যেককে ন্যায্য শট দেবে! ভোট দেওয়ার জন্য বিভাগগুলির মধ্যে সবচেয়ে অনন্য, সবচেয়ে সৃজনশীল, সবচেয়ে সুন্দর ইত্যাদি অন্তর্ভুক্ত থাকতে পারে এবং বিজয়ীরা একটি ভার্চুয়াল পুরস্কার পেতে পারে। ',

             'এই ইভেন্টটি সম্পূর্ণরূপে উপভোগ করার জন্য সময়সূচীতে পর্যাপ্ত সময় রয়েছে তা নিশ্চিত করার জন্য পৃথক গ্রেড স্তরের দ্বারা সর্বোত্তমভাবে অনুষ্ঠিত হয়। একটি গ্রেড স্তরের প্রতিটি শ্রেণীকক্ষ এমন একটি দেশ বাছাই করে যেখানে একটি অনন্য ছুটির ঐতিহ্য বা উদযাপন রয়েছে৷ উদাহরণগুলির মধ্যে রয়েছে ইসরায়েল, জার্মানি, ইংল্যান্ড, মেক্সিকো, ইত্যাদি। প্রতিটি দেশের দায়িত্বে থাকা শিক্ষক ঐতিহ্য এবং এর গুরুত্ব, সেইসাথে একটি নৈপুণ্যের কার্যকলাপ সম্পর্কে শিক্ষার্থীদের শেখানোর জন্য একটি দ্রুত পঠন-পাঠন বা ভিডিও করার পরিকল্পনা করেন। শিক্ষার্থীরা তারপরে তাদের নিজস্ব ভিন্ন সংস্কৃতি এবং মজার ঐতিহ্যগুলি শিখতে এবং অনুভব করতে প্রতিটি দেশে ঘুরতে ঘুরতে দিন কাটায়। ',

             'প্রতি বছর 2শে মার্চ পালিত হয়, রিড অ্যাক্রোস আমেরিকা ডে প্রথম প্রতিষ্ঠিত হয়েছিল ডক্টর সুয়েসের জন্মদিন উদযাপনের উপায় হিসেবে। আজ, এর মূল উদ্দেশ্য হল শিশুদের সচেতন হতে অনুপ্রাণিত করা এবং সাহায্য করা এবং ভাল পড়ার অভ্যাস উদযাপন করা। অনুরূপ বা ভিন্ন শ্রেণীকক্ষ এবং গ্রেড স্তরের শিক্ষার্থীরা বন্ধুদের পড়ার জন্য অংশীদার হয় এবং তাদের পড়ার ভালবাসায় ভাগ করে নেয়। ',

             'এটি ক্লাসিক ফিল্ড ডে ইভেন্টের একটি গ্রহণ যা সাধারণত সমস্ত গ্রেড স্তরের শিক্ষার্থীরা প্রতি বছর অংশগ্রহণ করে। কেকওয়াক বা রিলে রেসের মতো গড় ক্রিয়াকলাপের পরিবর্তে, STEM-এর সমস্ত এলাকায় ছাত্রদের চ্যালেঞ্জ করা হয়! এই ইভেন্টে একটি পেপার প্লেট মার্বেল রেস, কাপড়ের পিন জ্যামিতি, কাগজের বিমান চ্যালেঞ্জ, বা ইঞ্জিনিয়ারিং বিল্ডিং চ্যালেঞ্জগুলির একটি অ্যারের মতো কার্যকলাপ অন্তর্ভুক্ত থাকতে পারে। সুযোগগুলি অফুরন্ত এবং এই ইভেন্টটি আপনার বাচ্চাদের STEM-ভিত্তিক মজার অনেক দিকগুলির সাথে জড়িত করবে৷',

             'প্রাথমিক এবং মাধ্যমিক বিদ্যালয়গুলি তাদের অধিভুক্ত বা কাছাকাছি উচ্চ বিদ্যালয়ের সাথে একটি ইভেন্টের ব্যবস্থা করে যেখানে শীঘ্রই স্নাতকরা স্কুল পরিদর্শন করে এবং একটি কুচকাওয়াজে অংশ নেয়। গ্র্যাজুয়েটরা তাদের গাউন বা কলেজের পোশাক পরে এবং সঙ্গীতে ভরা হলওয়ের মধ্য দিয়ে উদযাপন করার পাশাপাশি অল্প বয়স্ক ছাত্রদের তাদের নিজেদের ভবিষ্যৎ সম্পর্কে চিন্তা ও উত্তেজিত করে। হলওয়েতে সারিবদ্ধ ছাত্রদের তাদের প্রিয় বিশ্ববিদ্যালয়ের পোশাক পরতে এবং গ্র্যাজুয়েট প্যারেডের মাধ্যমে উল্লাস করতে উত্সাহিত করা হয়৷',

             'এই ইভেন্টটি নিখুঁত ক্লাস বা স্কুল জুড়ে প্রণোদনা, বিশেষ করে যদি তাদের প্রিয় শিক্ষক থাকে তবে তারা একটি স্প্ল্যাট দিয়ে অবাক করতে চাই! একবার ক্লাস বা গ্রেড স্তরগুলি তাদের পূর্বনির্ধারিত লক্ষ্যে পৌঁছে গেলে, পুরো ছাত্র সংগঠনের সামনে মুখ থুবড়ে পড়ার জন্য একজন শিক্ষককে নির্বাচিত করা হয়। টার্গেট করা শিক্ষকের জন্য হয়তো সবচেয়ে মজার নয়, কিন্তু অন্য সবার জন্য একটি স্মরণীয় অভিজ্ঞতা! '
        ];

        foreach ($titels as $key => $value) {
            $upload       = new Upload();
            $upload->path = 'frontend/img/event/'.$key.'.webp';
            $upload->save();

            $row = new Event();
            $row->session_id  = setting('session');
            $row->title       = $value;
            $row->description = $descriptions[$key];
            $row->date        = date("Y-m-d", strtotime("+ ".$key." day"));
            $row->start_time  = date('H:m:s');
            $row->end_time    = date('H:m:s');
            $row->upload_id   = $upload->id;
            $row->address     = 'Resemont Tower, House 148, Road 13/B, Block E Banani Dhaka 1213.';
            $row->save();
        }

        foreach ($titels as $key => $value) {
            $en = new EventTranslate();
            $en->event_id = $key+1;
            $en->locale = 'en';
            $en->title = $value;
            $en->description = $descriptions[$key];
            $en->address = 'Resemont Tower, House 148, Road 13/B, Block E Banani Dhaka 1213.';
            $en->save();
        }

        foreach ($bn_titels as $key => $value) {
            $en = new EventTranslate();
            $en->event_id = $key+1;
            $en->locale = 'bn';
            $en->title = $value;
            $en->description = $bn_descriptions[$key];
            $en->address = 'রেসিমন্ট টাওয়ার, হাউজ 148, রোড 13/বি, ব্লক ই বনানী ঢাকা 1213।';
            $en->save();
        }
    }
}
