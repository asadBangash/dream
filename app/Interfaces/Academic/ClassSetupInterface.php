<?php

namespace App\Interfaces\Academic;

interface ClassSetupInterface
{

    public function getSections($id);

    public function all();

    public function getPaginateAll();

    public function store($request);

    public function show($id);

    public function update($request, $id);

    public function destroy($id);
}
