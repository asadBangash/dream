<?php

namespace App\Interfaces\Fees;

interface FeesMasterInterface
{

    public function all();
    public function allGroups();

    public function groupTypes($request);

    public function getPaginateAll();

    public function store($request);

    public function show($id);

    public function update($request, $id);

    public function destroy($id);
}
