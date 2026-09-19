<?php

namespace App\Interfaces\OnlineExamination;

interface OnlineExamInterface
{

    public function all();

    public function getAll();

    public function search($request);

    public function store($request);
    
    public function show($id);
    
    public function answer($id, $student_id);

    public function markSubmit($request);
    
    public function update($request, $id);
    
    public function destroy($id);

    public function getAllQuestions($id);
}
