<?php

namespace App\Repositories;

use App\Models\Session;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\DB;
use App\Interfaces\SessionInterface;
use App\Models\Examination\ExaminationSettings;
use App\Models\SessionTranslate;

class SessionRepository implements SessionInterface
{
    use ReturnFormatTrait;
    private $session;
    private $sessionTrans;

    public function __construct(Session $session , SessionTranslate  $sessionTrans)
    {
        $this->session = $session;
        $this->sessionTrans = $sessionTrans;
    }

    public function all()
    {
        return $this->session->active()->get();
    }

    public function getAll()
    {
        return Session::latest()->paginate(10);
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {

            $sessionStore              = new $this->session;
            $sessionStore->name        = $request->name;
            $sessionStore->start_date  = $request->start_date;
            $sessionStore->end_date    = $request->end_date;
            $sessionStore->status      = $request->status;
            $sessionStore->save();

            $exam_settings = ExaminationSettings::where('session_id', setting('session'))->get();

            foreach ($exam_settings as $key => $exam_setting) {
                $setting             = new ExaminationSettings();
                $setting->name       = $exam_setting->name;
                $setting->value      = $exam_setting->value;
                $setting->session_id = $sessionStore->id;
                $setting->save();
            }

            DB::commit();
            return $this->responseWithSuccess(___('alert.created_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function show($id)
    {
        return $this->session->find($id);
    }

    public function update($request, $id)
    {
        try {
            $sessionUpdate              = $this->session->findOrfail($id);
            $sessionUpdate->name       = $request->name;
            $sessionUpdate->start_date  = $request->start_date;
            $sessionUpdate->end_date    = $request->end_date;
            $sessionUpdate->status      = $request->status;
            $sessionUpdate->save();
            return $this->responseWithSuccess(___('alert.updated_successfully'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function destroy($id)
    {
        try {
            $sessionDestroy = $this->session->find($id);
            ExaminationSettings::where('session_id', $sessionDestroy->id)->delete();
            $sessionDestroy->delete();
            return $this->responseWithSuccess(___('alert.deleted_successfully'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function translates($id){

        return $this->sessionTrans->where('session_id',$id)->get()->groupBy('locale');
    }

    public function translateUpdate($request, $id){
        DB::beginTransaction();
        try {
            $delete_old = $this->sessionTrans->where('session_id',$id)->delete();
            $session = $this->show($id);

            foreach($request->name as $key => $name){
                $row                   = new $this->sessionTrans;
                $row->session_id        = $id ;
                $row->locale           = $key ;
                $row->name             = $name;
                $row->save();
            }

            DB::commit();
            return $this->responseWithSuccess(___('alert.updated_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }
}
