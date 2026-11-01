<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

$dupRolls = DB::table('students')
    ->select('branch_id', 'roll_no', DB::raw('count(*) as c'))
    ->whereNotNull('roll_no')
    ->groupBy('branch_id', 'roll_no')
    ->having('c', '>', 1)
    ->get();

echo "Duplicate roll+branch in DB:\n";
print_r($dupRolls->toArray());

$withoutCode = DB::table('students')->whereNull('student_code')->orWhere('student_code', '')->count();
echo "Students without student_code: {$withoutCode}\n";
