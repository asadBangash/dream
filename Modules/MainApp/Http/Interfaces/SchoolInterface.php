<?php

namespace Modules\MainApp\Http\Interfaces;

interface SchoolInterface
{

    public function all();

    public function activeAll();

    public function getAll();

    public function store($request);

    public function show($id);

    public function update($request, $id);

    public function destroy($id);
}
