<?php

namespace App\Interfaces\StudentInfo;

interface ParentGuardianInterface
{

    public function all();

    public function getPaginateAll();
    
    public function searchParent($request);

    public function getParent($request);

    public function store($request);

    public function show($id);

    public function update($request, $id);

    public function destroy($id);
}
