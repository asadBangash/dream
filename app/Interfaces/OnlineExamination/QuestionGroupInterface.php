<?php

namespace App\Interfaces\OnlineExamination;

interface QuestionGroupInterface
{

    public function all();

    public function getAll();

    public function search($request);
    
    public function store($request);

    public function show($id);

    public function update($request, $id);

    public function destroy($id);
}
