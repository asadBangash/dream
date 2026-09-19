<?php

namespace App\Http\Controllers;

use App\Repositories\Academic\ClassesRepository;
use Illuminate\Http\Request;

class SubjectAttendanceController extends Controller
{
    private $classRepo;

    function __construct(ClassesRepository $classRepo,)
    {
        $this->classRepo         = $classRepo;
    }


    public function index()
    {

    }
}
