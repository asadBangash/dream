<?php

namespace App\Interfaces\Fees;

interface FeesAssignInterface
{

    public function all();

    public function getPaginateAll();

    public function store($request);

    public function show($id);

    public function update($request, $id);

    public function destroy($id);

    public function groupTypes($request);
}
