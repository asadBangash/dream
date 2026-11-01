<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

if (Schema::hasTable('branches')) {
    echo "Branches:\n";
    $cols = Schema::getColumnListing('branches');
    foreach (DB::table('branches')->get(array_intersect(['id', 'name', 'code'], $cols)) as $b) {
        echo '  ' . json_encode($b) . "\n";
    }
}

echo "Genders:\n";
foreach (DB::table('genders')->get(['id', 'name']) as $g) {
    echo "  {$g->id} {$g->name}\n";
}

echo "Departments:\n";
foreach (DB::table('departments')->get(['id', 'name']) as $d) {
    echo "  {$d->id} {$d->name}\n";
}

echo "Classes:\n";
foreach (DB::table('classes')->get(['id', 'name']) as $c) {
    echo "  {$c->id} {$c->name}\n";
}

echo "Sections:\n";
foreach (DB::table('sections')->get(['id', 'name']) as $s) {
    echo "  {$s->id} {$s->name}\n";
}

echo 'Active session id: ' . setting('session') . "\n";

echo "Class setups (session + class + sections):\n";
$setups = DB::table('class_setups')->where('session_id', setting('session'))->get();
foreach ($setups as $cs) {
    $className = DB::table('classes')->where('id', $cs->classes_id)->value('name');
    $children = DB::table('class_setup_childrens')->where('class_setup_id', $cs->id)->pluck('section_id');
    $secNames = DB::table('sections')->whereIn('id', $children)->pluck('name', 'id');
    echo "  setup#{$cs->id} class={$className} (id {$cs->classes_id}) sections: " . json_encode($secNames) . "\n";
}
