<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

use Illuminate\Http\Request;

$email = $argv[1] ?? 'superadmin@tdelcta.com';
$password = $argv[2] ?? '123456';

$get = Request::create('/login', 'GET');
$getResponse = $kernel->handle($get);
preg_match('/name="_token" value="([^"]+)"/', $getResponse->getContent(), $m);
$token = $m[1] ?? '';
$kernel->terminate($get, $getResponse);

$post = Request::create('/login', 'POST', [
    '_token' => $token,
    'email' => $email,
    'password' => $password,
], [], [], [
    'HTTP_ACCEPT' => 'text/html',
    'HTTP_REFERER' => rtrim(env('APP_URL'), '/') . '/login',
]);
$post->cookies = $get->cookies;
foreach ($getResponse->headers->getCookies() as $cookie) {
    $post->cookies->set($cookie->getName(), $cookie->getValue());
}

$postResponse = $kernel->handle($post);
$status = $postResponse->getStatusCode();
$location = $postResponse->headers->get('Location');
echo "POST /login status={$status}" . PHP_EOL;
echo "Location: " . ($location ?: '(none, likely validation error page)') . PHP_EOL;
if ($status === 302 && str_contains((string) $location, 'dashboard')) {
    echo "LOGIN FLOW: OK (redirect to dashboard)" . PHP_EOL;
} elseif ($status === 302) {
    echo "LOGIN FLOW: redirect to {$location}" . PHP_EOL;
} else {
    if (preg_match('/invalid-feedback[^>]*>([^<]+)/', $postResponse->getContent(), $err)) {
        echo "Error hint: " . trim($err[1]) . PHP_EOL;
    }
    echo "LOGIN FLOW: FAILED" . PHP_EOL;
}

$kernel->terminate($post, $postResponse);
