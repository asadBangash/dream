<?php

namespace App\Interfaces\StudentInfo;

interface StudentInterface
{

    public function all();

    public function getStudents($request);

    public function getPaginateAll();
    public function searchStudents($request);

    public function store($request);

    public function show($id);

    public function update($request, $id);

    public function destroy($id);
}
