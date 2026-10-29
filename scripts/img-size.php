<?php
$path = $argv[1] ?? '';
$info = getimagesize($path);
echo ($info[0] ?? 0) . 'x' . ($info[1] ?? 0);
