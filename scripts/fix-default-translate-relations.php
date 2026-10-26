<?php

$root = dirname(__DIR__) . '/app/Models';
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root));
$fixed = 0;

foreach ($iterator as $file) {
    if (!$file->isFile() || $file->getExtension() !== 'php') {
        continue;
    }

    $path = $file->getPathname();
    $content = file_get_contents($path);

    if (!str_contains($content, 'return $relation = $this->hasOne')) {
        continue;
    }

    $content = preg_replace(
        '/\$locale = request\(\)->locale \?\? app\(\)->getLocale\(\);\s*return \$relation = \$this->hasOne\(([^)]+)\)->where\(\'locale\', request\(\)->locale \?\? config\(\'app\.locale\'\)\);\s*->where\(\'locale\', \$locale\);/s',
        '$locale = request()->locale ?? app()->getLocale();

        return $this->hasOne($1)->where(\'locale\', $locale);',
        $content,
        1,
        $count
    );

    if ($count === 1) {
        file_put_contents($path, $content);
        $fixed++;
        echo "Fixed: {$path}\n";
    }
}

echo "Fixed {$fixed} files.\n";
