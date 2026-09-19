<?php

namespace App\Http\Controllers\OnlineExamination;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use App\Repositories\Academic\ClassesRepository;
use App\Interfaces\OnlineExamination\QuestionBankInterface;
use App\Http\Requests\OnlineExamination\QuestionBank\StoreRequest;
use App\Http\Requests\OnlineExamination\QuestionBank\UpdateRequest;
use App\Interfaces\OnlineExamination\QuestionGroupInterface;

class QuestionBankController extends Controller
{
    private $repo;
    private $groupRepo;

    function __construct(
        QuestionBankInterface $repo,
        QuestionGroupInterface $groupRepo,
    )
    {

        if (!Schema::hasTable('settings') && !Schema::hasTable('users')  ) {
            abort(400);
        } 
        $this->groupRepo  = $groupRepo;
        $this->repo       = $repo; 
    }

    public function index()
    {
        $data['question_bank'] = $this->repo->getAll();
        $data['title']         = ___('online-examination.question_bank');
        return view('backend.online-examination.question-bank.index', compact('data'));
    }

    
    public function search(Request $request)
    {
        $data['request']        = $request;
        $data['title']          = ___('online-examination.question_bank');
        $data['question_bank']  = $this->repo->search($request);
        return view('backend.online-examination.question-bank.index', compact('data'));
    }

    public function create()
    {
        $data['title']                    = ___('online-examination.create_question_bank');
        $data['question_groups']          = $this->groupRepo->all();
        return view('backend.online-examination.question-bank.create', compact('data'));
    }

    public function store(StoreRequest $request)
    {
        // dd($request->all());
        $result = $this->repo->store($request);
        if($result['status']){
            return redirect()->route('question-bank.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $data['question_bank'] = $this->repo->show($id);
        $data['question_groups']          = $this->groupRepo->all();
        $data['title']         = ___('online-examination.edit_question_bank');
        return view('backend.online-examination.question-bank.edit', compact('data'));
    }

    public function update(UpdateRequest $request, $id)
    {
        // dd($request->all());
        $result = $this->repo->update($request, $id);
        if($result['status']){
            return redirect()->route('question-bank.index')->with('success', $result['message']);
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

    public function getQuestionGroup(Request $request)
    {
        $result = $this->repo->getQuestionGroup($request);
        return response()->json($result);
    }
}
