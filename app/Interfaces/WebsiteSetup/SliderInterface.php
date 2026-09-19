<?php

namespace App\Interfaces\WebsiteSetup;

interface SliderInterface
{
    public function all();

    public function getAll();

    public function store($request);

    public function show($id);

    public function update($request, $id);

    public function destroy($id);
}