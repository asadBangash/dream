<?php

namespace App\Http\Controllers\Academic;

use Illuminate\Http\Request;
use App\Interfaces\UserInterface;
use App\Http\Controllers\Controller;
use App\Interfaces\SessionInterface;
use App\Traits\ApiReturnFormatTrait;
use App\Models\Academic\TimeSchedule;
use App\Interfaces\Academic\ShiftInterface;
use App\Interfaces\Academic\ClassesInterface;
use App\Interfaces\Academic\SectionInterface;
use App\Interfaces\Academic\SubjectInterface;
use App\Models\Academic\SubjectAssignChildren;
use App\Repositories\Academic\ClassRoomRepository;
use App\Repositories\Academic\ClassSetupRepository;
use App\Repositories\Academic\ClassRoutineRepository;
use App\Repositories\Academic\TimeScheduleRepository;
use App\Repositories\Academic\SubjectAssignRepository;
use App\Http\Requests\Academic\ClassRoutine\ClassRoutineStoreRequest;
use App\Http\Requests\Academic\ClassRoutine\ClassRoutineUpdateRequest;
use App\Http\Requests\Academic\SubjectAssign\SubjectAssignStoreRequest;
use App\Http\Requests\Academic\SubjectAssign\SubjectAssignUpdateRequest;

class ClassRoutineController extends Controller
{
    use ApiReturnFormatTrait;

    private $repo;
    private $sessionRepo;
    private $classesRepo;
    private $sectionRepo;
    private $shiftRepo;
    private $subjectRepo;
    private $staffRepo;
    private $classRoomRepo;
    private $subjectAssignRepo;
    private $timeScheduleRepo;
    private $classSetupRepo;

    function __construct(
        ClassRoutineRepository    $repo,
        SessionInterface          $sessionRepo,
        ClassesInterface          $classesRepo,
        SectionInterface          $sectionRepo,
        ShiftInterface            $shiftRepo,
        SubjectInterface          $subjectRepo,
        UserInterface             $staffRepo,
        ClassRoomRepository       $classRoomRepo,
        SubjectAssignRepository   $subjectAssignRepo,
        TimeScheduleRepository    $timeScheduleRepo,
        ClassSetupRepository      $classSetupRepo,
        )
    {
        $this->repo                 = $repo; 
        $this->sessionRepo          = $sessionRepo; 
        $this->classesRepo          = $classesRepo; 
        $this->sectionRepo          = $sectionRepo; 
        $this->shiftRepo            = $shiftRepo; 
        $this->subjectRepo          = $subjectRepo; 
        $this->staffRepo            = $staffRepo; 
        $this->classRoomRepo        = $classRoomRepo; 
        $this->subjectAssignRepo    = $subjectAssignRepo; 
        $this->timeScheduleRepo     = $timeScheduleRepo; 
        $this->classSetupRepo       = $classSetupRepo; 
    }
    
    public function index()
    {
        $data['title']             = ___('academic.class_routine');
        $data['class_routines']    = $this->repo->getPaginateAll();

        return view('backend.academic.class-routine.index', compact('data'));
        
    }

    public function create()
    {
        $data['title']              = ___('academic.class_routine');
        $data['classes']            = $this->classesRepo->assignedAll();
        $data['sections']           = $this->sectionRepo->all();
        $data['shifts']             = $this->shiftRepo->all();
        // $data['subjects']           = $this->subjectRepo->all();
        return view('backend.academic.class-routine.create', compact('data'));
        
    }
    
    public function addClassRoutine(Request $request)
    {
        $counter                 = $request->counter;

        
        $data['subjects']        = $this->subjectAssignRepo->getSubjects($request);
        // $data['subjects']        = $this->subjectRepo->all();
        // $data['teachers']        = $this->staffRepo->all();
        $data['class_rooms']     = $this->classRoomRepo->all();
        $data['time_schedules']  = $this->timeScheduleRepo->allClassSchedule();
        return view('backend.academic.class-routine.add-class-routine', compact('counter','data'))->render();
    }

    public function store(ClassRoutineStoreRequest $request)
    {
        $result = $this->repo->store($request);
        if($result['status']){
            return redirect()->route('class-routine.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $data['title']              = ___('academic.class_routine');
        $data['class_routine']      = $this->repo->show($id);
    
        $data['classes']            = $this->classesRepo->assignedAll();
        $data['sections']           = $this->classSetupRepo->getSections($data['class_routine']->classes_id);
    

        $data['shifts']             = $this->shiftRepo->all();
        $data['subjects']           = $this->subjectAssignRepo->getSubjects($data['class_routine']);

        $data['class_rooms']        = $this->classRoomRepo->all();
        $data['time_schedules']     = $this->timeScheduleRepo->allClassSchedule();

        return view('backend.academic.class-routine.edit', compact('data'));
    }

    public function update(ClassRoutineUpdateRequest $request, $id)
    {
        // dd($request->all());
        $result = $this->repo->update($request, $id);
        if($result['status']){
            return redirect()->route('class-routine.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function delete($id)
    {
        
        $result = $this->repo->destroy($id);
        if($result['status']):
            $success[0] = $result['message'];
            $success[1] = 'success';
            $success[2] = ___('alert.deleted');
            $success[3] = ___('alert.OK');
            return response()->json($success);
        else:
            $success[0] = $result['message'];
            $success[1] = 'error';
            $success[2] = ___('alert.oops');
            return response()->json($success);
        endif;      
    }

    public function checkClassRoutine(Request $request)
    {
        
        $result = $this->repo->checkClassRoutine($request);
       
        return response()->json($result);
    
    }




}
