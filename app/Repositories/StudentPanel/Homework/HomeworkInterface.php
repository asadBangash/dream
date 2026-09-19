<?php

namespace App\Repositories\StudentPanel\Homework;

interface HomeworkInterface
{
    public function index();

    public function submit($request);
}
