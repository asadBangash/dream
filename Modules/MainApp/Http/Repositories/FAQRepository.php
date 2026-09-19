<?php

namespace Modules\MainApp\Http\Repositories;

use App\Enums\Settings;
use App\Traits\ReturnFormatTrait;
use Modules\MainApp\Entities\FrequentlyAskedQuestion;
use Modules\MainApp\Http\Interfaces\FAQInterface;

class FAQRepository implements FAQInterface
{
    use ReturnFormatTrait;
    private $model;

    public function __construct(FrequentlyAskedQuestion $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->active()->orderBy('position')->get();
    }

    public function getAll()
    {
        return $this->model->orderBy('position')->paginate(Settings::PAGINATE);
    }

    public function store($request)
    {
        try {
            $row              = new $this->model;
            $row->question    = $request->question;
            $row->answer      = $request->answer;
            $row->position    = $request->position;
            $row->status      = $request->status;
            $row->save();

            return $this->responseWithSuccess(___('alert.created_successfully'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function show($id)
    {
        return $this->model->find($id);
    }

    public function update($request, $id)
    {
        try {
            $row              = $this->model->findOrfail($id);
            $row->question    = $request->question;
            $row->answer      = $request->answer;
            $row->position    = $request->position;
            $row->status      = $request->status;
            $row->save();

            return $this->responseWithSuccess(___('alert.updated_successfully'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function destroy($id)
    {
        try {
            $row = $this->model->find($id);
            $row->delete();
            return $this->responseWithSuccess(___('alert.deleted_successfully'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }
}
