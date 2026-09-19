<?php

namespace Modules\MainApp\Http\Repositories;

use App\Enums\Settings;
use App\Traits\CommonHelperTrait;
use App\Traits\ReturnFormatTrait;
use Modules\MainApp\Entities\Testimonial;
use Modules\MainApp\Http\Interfaces\TestimonialInterface;

class TestimonialRepository implements TestimonialInterface
{
    use ReturnFormatTrait;
    use CommonHelperTrait;
    private $model;

    public function __construct(Testimonial $model)
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
            $row->name        = $request->name;
            $row->upload_id   = $this->UploadImageCreate($request->icon, 'backend/uploads/testimonial', $row->upload_id);
            $row->link        = $request->link;
            $row->rating      = $request->rating;
            $row->position    = $request->position;
            $row->description = $request->description;
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
            $row->name        = $request->name;
            $row->upload_id   = $this->UploadImageUpdate($request->icon, 'backend/uploads/testimonial', $row->upload_id);
            $row->link        = $request->link;
            $row->rating      = $request->rating;
            $row->position    = $request->position;
            $row->description = $request->description;
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
            $this->UploadImageDelete($row->upload_id);
            $row->delete();
            return $this->responseWithSuccess(___('alert.deleted_successfully'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }
}
