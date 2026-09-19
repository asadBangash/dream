<?php

namespace App\Interfaces\Academic;

interface ClassesInterface
{

    public function assignedAll();

    public function all();

    public function getAll();

    public function store($request);

    public function show($id);

    public function update($request, $id);

    public function destroy($id);

    public function translates($id);

    public function translateUpdate($request, $id);
}
