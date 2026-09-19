<?php

namespace App\Http\Controllers\Fees;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Fees\Assign\FeesAssignStoreRequest;
use App\Http\Requests\Fees\Assign\FeesAssignUpdateRequest;
use App\Http\Requests\Fees\Assign\FeesImportRequest;
use App\Imports\FeesImport;
use App\Interfaces\Fees\FeesTypeInterface;
use App\Interfaces\Fees\FeesGroupInterface;
use App\Interfaces\Fees\FeesAssignInterface;
use App\Repositories\Academic\ClassesRepository;
use App\Repositories\Academic\ClassSetupRepository;
use App\Repositories\Academic\SectionRepository;
use App\Repositories\Fees\FeesMasterRepository;
use App\Repositories\GenderRepository;
use App\Repositories\StudentInfo\StudentCategoryRepository;
use App\Repositories\StudentInfo\StudentRepository;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Exceptions\ImportValidationException;

class FeesAssignController extends Controller
{
    private $repo;
    private $typeRepo;
    private $groupRepo;
    private $feesMasterRepo;
    private $genderRepo;
    private $categoryRepo;
    private $classRepo;
    private $sectionRepo;
    private $classSetupRepo;
    private $studentRepo;

    function __construct(
        FeesAssignInterface $repo,
        FeesTypeInterface $typeRepo,
        FeesGroupInterface $groupRepo,
        FeesMasterRepository $feesMasterRepo,
        GenderRepository $genderRepo,
        StudentCategoryRepository $categoryRepo,
        ClassesRepository $classRepo,
        SectionRepository $sectionRepo,
        ClassSetupRepository $classSetupRepo,
        StudentRepository $studentRepo
        )
    {
        $this->repo              = $repo;
        $this->typeRepo          = $typeRepo;
        $this->groupRepo         = $groupRepo;
        $this->feesMasterRepo    = $feesMasterRepo;
        $this->genderRepo        = $genderRepo;
        $this->categoryRepo      = $categoryRepo;
        $this->classRepo         = $classRepo;
        $this->sectionRepo       = $sectionRepo;
        $this->classSetupRepo    = $classSetupRepo;
        $this->studentRepo       = $studentRepo;
    }

    public function index()
    {
        $data['title']        = ___('fees.fees_assign');
        $data['fees_assigns'] = $this->repo->getPaginateAll();
        return view('backend.fees.assign.index', compact('data'));
    }

    public function show(Request $request){

        $data['fees_assign']  = $this->repo->show($request->id);
        return view('backend.student-info.student.view', compact('data'))->render();
    }

    public function create()
    {
        $data['title']        = ___('fees.fees_assign');
        $data['classes']      = $this->classRepo->assignedAll();
        // $data['sections']     = $this->sectionRepo->all();
        $data['sections']     = [];
        $data['fees_groups']  = $this->feesMasterRepo->allGroups();
        $data['genders']      = $this->genderRepo->all();
        $data['categories']   = $this->categoryRepo->all();
        return view('backend.fees.assign.create', compact('data'));
    }

    public function store(FeesAssignStoreRequest $request)
    {

        $result = $this->repo->store($request);
        if($result['status']){
            return redirect()->route('fees-assign.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message'])->withInput();
    }

    public function edit($id)
    {
        $data['title']        = ___('fees.fees_assign');
        $data['fees_assign']  = $this->repo->show($id);
        $data['classes']      = $this->classRepo->assignedAll();
        // $data['sections']     = $this->sectionRepo->all();
        $data['sections']     = $this->classSetupRepo->getSections($data['fees_assign']->classes_id);
        $data['fees_groups']  = $this->feesMasterRepo->allGroups();

        $data['assigned_fes_masters']  =  array_unique($data['fees_assign']->feesAssignChilds->pluck('fees_master_id')->toArray());

        $data['fees_masters']  = $this->feesMasterRepo->all()->where('fees_group_id', $data['fees_assign']->fees_group_id);

        $data['genders']      = $this->genderRepo->all();
        $data['categories']   = $this->categoryRepo->all();

        $request = new Request();
        $request->replace(['class' => $data['fees_assign']->classes_id, 'section' => $data['fees_assign']->section_id, 'gender' => $data['fees_assign']->gender_id]);

        $data['students']     = $this->studentRepo->getStudents($request);

        return view('backend.fees.assign.edit', compact('data'));
    }

    public function update(FeesAssignUpdateRequest $request, $id)
    {
        // dd($request->all());
        $result = $this->repo->update($request, $id);
        if($result['status']){
            return redirect()->route('fees-assign.index')->with('success', $result['message']);
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

    public function getFeesAssignStudents(Request $request)
    {
        $students = $this->repo->getFeesAssignStudents($request);
        return view('backend.fees.assign.fees-assing-students-list', compact('students'))->render();
    }

    public function getAllTypes(Request $request)
    {
        $types = $this->repo->groupTypes($request);
        return view('backend.fees.assign.fees-types', compact('types'))->render();
    }

    public function import()
    {
        $data['title']     = ___('fees.fees_import');
        $data['fees_groups']  = $this->feesMasterRepo->allFeesGroups();
        return view('backend.fees.assign.import', compact('data'));
    }

    public function importSubmit(FeesImportRequest $reqeust)
    {
        try {
            Excel::import(new FeesImport($reqeust->fees_group), $reqeust->file('file'));
            return redirect()->route('fees-assign.index')->with('success', ___('alert.Operation Successful'));
        } catch (ImportValidationException $e) {
            $errors = $e->errors();
            return back()->withErrors($errors)->withInput();
        }
    }

    public function sampleDownload()
    {
        $filePath = public_path('bulk_fees_assingn_sample.xlsx');
        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return redirect()->back()->with('error', 'File not found!');
        }
    }



}
