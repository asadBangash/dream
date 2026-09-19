<?php

namespace App\Interfaces\Examination;

interface ExamAssignInterface
{

    public function all();

    public function getPaginateAll();

    public function getExamType($request);

    public function store($request);

    public function show($id);

    public function update($request, $id);

    public function destroy($id);

    public function getSubjects($request);

    public function checkSubmit($request);
}
