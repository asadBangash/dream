<?php

namespace Modules\MainApp\Http\Interfaces;

interface SectionsInterface
{
    public function all();

    public function getAll();

    public function show($id);

    public function update($request, $id);
}