<?php

namespace App\Interfaces\Library;

interface MemberCategoryInterface
{
    public function all();

    public function getAll();

    public function store($request);

    public function show($id);

    public function update($request, $id);

    public function destroy($id);
}