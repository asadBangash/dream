<?php

namespace App\Interfaces\StudentInfo;

interface OnlineAdmissionInterface
{

    public function all();

    public function show($id);

    public function store($request);

    public function destroy($id);
}
