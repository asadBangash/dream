<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Academic\ClassRoom\ClassRoomStoreRequest;
use App\Http\Requests\Academic\ClassRoom\ClassRoomUpdateRequest;
use App\Interfaces\Academic\ClassRoomInterface;

class ClassRoomController extends Controller
{
    private $repo;

    function __construct(ClassRoomInterface $repo)
    {
        $this->repo       = $repo; 
    }
    
    public function index()
    {
        $data['title']              = ___('academic.class_room');
        $data['class_rooms'] = $this->repo->getPaginateAll();

        return view('backend.academic.class-room.index', compact('data'));
        
    }

    public function create()
    {
        $data['title']              = ___('academic.class_room');
        return view('backend.academic.class-room.create', compact('data'));
        
    }

    public function store(ClassRoomStoreRequest $request)
    {
        
        $result = $this->repo->store($request);
        if($result['status']){
            return redirect()->route('class-room.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $data['class_room']        = $this->repo->show($id);
        $data['title']       = ___('academic.class_room');
        return view('backend.academic.class-room.edit', compact('data'));
    }

    public function update(ClassRoomUpdateRequest $request, $id)
    {
        $result = $this->repo->update($request, $id);
        if($result['status']){
            return redirect()->route('class-room.index')->with('success', $result['message']);
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




}
