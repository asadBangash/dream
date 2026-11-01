<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

echo 'setting(session): ' . setting('session') . "\n";
echo "Sessions:\n";
foreach (DB::table('sessions')->get(['id', 'name', 'status']) as $s) {
    echo "  {$s->id} | {$s->name} | status={$s->status}\n";
}

echo 'students count: ' . DB::table('students')->count() . "\n";
echo 'excel student_code count: ' . DB::table('students')->where('student_code', 'like', 'excel-combined-%')->count() . "\n";

foreach (DB::table('sessions')->pluck('id') as $sid) {
    $c = DB::table('session_class_students')->where('session_id', $sid)->count();
    echo "session_class_students session_id={$sid}: {$c}\n";
}

echo "By branch (students):\n";
foreach (DB::table('students')->selectRaw('branch_id, count(*) as c')->groupBy('branch_id')->get() as $r) {
    echo "  branch {$r->branch_id}: {$r->c}\n";
}
