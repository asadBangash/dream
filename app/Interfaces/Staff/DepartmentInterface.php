<?php

namespace App\Interfaces\Staff;

interface DepartmentInterface
{

    public function all();

    public function getPaginateAll();
    public function getAsOptions();

    public function store($request);

    public function show($id);

    public function update($request, $id);

    public function destroy($id);
}
