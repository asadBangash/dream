<?php

require __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$path = __DIR__ . '/../Student_Records.xlsx';
$reader = IOFactory::load($path);
$sheet = $reader->getSheetByName('Combined Master');
$highest = $sheet->getHighestRow();

$headers = [];
for ($c = 1; $c <= 20; $c++) {
    $headers[$c] = trim((string) $sheet->getCellByColumnAndRow($c, 1)->getValue());
}

echo "Headers:\n";
print_r(array_filter($headers));

for ($r = 2; $r <= min(6, $highest); $r++) {
    echo "\n--- Row $r ---\n";
    foreach ($headers as $c => $h) {
        if ($h === '') {
            continue;
        }
        echo "$h: " . trim((string) $sheet->getCellByColumnAndRow($c, $r)->getFormattedValue()) . "\n";
    }
}

$branchGender = [];
$classes = [];
$sections = [];
$statuses = [];
for ($r = 2; $r <= $highest; $r++) {
    $bg = trim((string) $sheet->getCellByColumnAndRow(3, $r)->getFormattedValue());
    if ($bg !== '') {
        $branchGender[$bg] = ($branchGender[$bg] ?? 0) + 1;
    }
    $cl = trim((string) $sheet->getCellByColumnAndRow(8, $r)->getFormattedValue());
    if ($cl !== '') {
        $classes[$cl] = ($classes[$cl] ?? 0) + 1;
    }
    $sec = trim((string) $sheet->getCellByColumnAndRow(9, $r)->getFormattedValue());
    if ($sec !== '') {
        $sections[$sec] = ($sections[$sec] ?? 0) + 1;
    }
    $st = trim((string) $sheet->getCellByColumnAndRow(14, $r)->getFormattedValue());
    if ($st !== '') {
        $statuses[$st] = ($statuses[$st] ?? 0) + 1;
    }
}

echo "\nBranch/Gender counts:\n";
print_r($branchGender);
echo "\nClasses:\n";
print_r($classes);
echo "\nSections:\n";
print_r($sections);
echo "\nStatuses:\n";
print_r($statuses);
echo "\nTotal data rows: " . ($highest - 1) . "\n";

$depts = [];
for ($r = 2; $r <= $highest; $r++) {
    $d = trim((string) $sheet->getCellByColumnAndRow(7, $r)->getFormattedValue());
    if ($d !== '') {
        $depts[$d] = ($depts[$d] ?? 0) + 1;
    }
}
echo "\nDepartments in Excel:\n";
print_r($depts);

$classSectionPairs = [];
for ($r = 2; $r <= $highest; $r++) {
    $cl = trim((string) $sheet->getCellByColumnAndRow(8, $r)->getFormattedValue());
    $sec = trim((string) $sheet->getCellByColumnAndRow(9, $r)->getFormattedValue());
    $key = $cl . ' | ' . $sec;
    $classSectionPairs[$key] = ($classSectionPairs[$key] ?? 0) + 1;
}
echo "\nClass | Section pairs:\n";
ksort($classSectionPairs);
foreach ($classSectionPairs as $k => $v) {
    echo "  $k ($v)\n";
}
