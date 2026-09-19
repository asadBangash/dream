<?php

namespace App\Interfaces\StudentInfo;

interface StudentCategoryInterface
{

    public function all();

    public function getPaginateAll();

    public function store($request);

    public function show($id);

    public function update($request, $id);

    public function destroy($id);
}
