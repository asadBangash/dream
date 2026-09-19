<?php

namespace App\Repositories\SmsMailTemplate;

interface SmsMailTemplateInterface
{
    public function all();

    public function smsAll();

    public function getPaginateAll();

    public function store($request);

    public function search($request);

    public function show($id);

    public function update($request, $id);
}
