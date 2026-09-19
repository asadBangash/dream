<?php

namespace App\Interfaces\WebsiteSetup;

interface DepartmentContactInterface
{
    public function all();

    public function getAll();

    public function store($request);

    public function show($id);

    public function update($request, $id);

    public function destroy($id);
}