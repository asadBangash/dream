<?php

namespace App\Interfaces\Academic;

interface ExamRoutineInterface
{

    public function all();

    public function getPaginateAll();

    public function store($request);

    public function getSubjects($request);

    public function show($id);

    public function update($request, $id);

    public function destroy($id);

    public function checkExamRoutine($request);
}
