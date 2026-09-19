<?php

namespace App\Http\Controllers\Admin;


use App\Models\Staff\Staff;
use Illuminate\Http\Request;
use App\Models\Academic\Classes;
use App\Http\Controllers\Controller;
use App\Repositories\RoleRepository;
use App\Models\Academic\SubjectAssign;
use App\Repositories\LanguageRepository;
use App\Models\Academic\SubjectAssignChildren;
use App\Repositories\Staff\DepartmentRepository;
use App\Repositories\Academic\ClassSetupRepository;
use App\Repositories\NoticeBoard\NoticeBoardRepository;
use App\Http\Requests\NoticeBoard\NoticeBoardStoreRequest;
use App\Models\Academic\ClassSetup;

class NoticeBoardController extends Controller
{
    private $repo;
    private $roleRepo;
    private $lang_repo;
    private $classSetupRepo;
    private $departmentRepo;

    function __construct(NoticeBoardRepository $repo, RoleRepository $roleRepo, LanguageRepository $lang_repo, ClassSetupRepository $classSetupRepo, DepartmentRepository $departmentRepo)
    {
        $this->repo               = $repo;
        $this->roleRepo           = $roleRepo;
        $this->lang_repo          = $lang_repo;
        $this->classSetupRepo          = $classSetupRepo;
        $this->departmentRepo          = $departmentRepo;
    }

    public function index()
    {
        $data['title']              = ___('common.notice_board');
        $data['notice-boards']      = $this->repo->getPaginateAll();

        return view('backend.communication.notice-board.index', compact('data'));
    }

    public function create()
    {
        $data['title']                  = ___('common.notice_board_create');
        if(auth()->user()->role_id == 5){
            $data['roles']                  = $this->roleRepo->student_parent_roles();
            $data['departments'] = $this->departmentRepo->staffDepartment();
        }else{
            $data['roles']                  = $this->roleRepo->all();
            $data['departments']    = $this->departmentRepo->getAsOptions();
        }
        $data['classes']            = $this->getClassList();
        return view('backend.communication.notice-board.create', compact('data'));
    }

    private function getClassList(){

        if(auth()->user()->role_id == 5 && auth()->user()->staff){
            $classesIds = SubjectAssignChildren::where('staff_id', auth()->user()->staff->id)
                        ->pluck('subject_assign_id') // Get the related subject_assign_id values
                        ->toArray();

            $uniqueClassesIds = SubjectAssign::whereIn('id', $classesIds)
                                        ->pluck('classes_id') // Assuming the column name is classes_id in SubjectAssign
                                        ->unique() // Ensure the values are unique
                                        ->toArray();


            return ClassSetup::whereIn('id', $uniqueClassesIds)->where('session_id', setting('session'))->get();


        }else{
            return $this->classSetupRepo->all();
        }

    }

    public function store(NoticeBoardStoreRequest $request)
    {
        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('notice-board.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id, Request $request)
    {
        $data['notice-board']           = $this->repo->show($id);
        $data['title']                  = ___('common.notice_board_edit');
        $data['roles']                  = $this->roleRepo->all();
        $data['classes']                = $this->classSetupRepo->all();
        $data['departments']            = $this->departmentRepo->getAsOptions();
        return view('backend.communication.notice-board.edit', compact('data'));
    }

    public function update(NoticeBoardStoreRequest $request, $id)
    {
        $result = $this->repo->update($request, $id);
        if ($result['status']) {
            return redirect()->route('notice-board.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function delete($id)
    {

        $result = $this->repo->destroy($id);
        if ($result['status']):
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

    public function translate($id)
    {
        $data['notice_board']      = $this->repo->show($id);
        $data['translates']      = $this->repo->translates($id);
        $data['languages']      = $this->lang_repo->all();
        $data['title']       = ___('website.Edit Notice Board');
        return view('backend.communication.notice-board.translate', compact('data'));
    }


    public function translateUpdate(Request $request, $id)
    {
        $result = $this->repo->translateUpdate($request, $id);
        if ($result['status']) {
            return redirect()->route('notice-board.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }
}
