<?php


namespace Modules\MultiBranch\Interfaces;


interface BranchInterface
{
    public function all();

    public function paginate($limit);

    public function store($request);

    public function update($request, $id);

    public function show($id);

    public function delete($id);
}
