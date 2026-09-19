<?php

namespace App\Repositories\SmsMailLog;

interface SmsMailLogInterface
{
    public function all();

    public function getPaginateAll();

    public function store($request);

    public function search($request);

    public function show($id);

    public function update($request, $id);
}
