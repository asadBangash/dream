<?php

namespace App\Repositories\WebsiteSetup;

use App\Enums\Settings;
use App\Interfaces\WebsiteSetup\GalleryInterface;
use App\Models\Gallery;
use Illuminate\Support\Facades\DB;
use App\Traits\CommonHelperTrait;
use App\Traits\ReturnFormatTrait;

class GalleryRepository implements GalleryInterface{

    use ReturnFormatTrait;
    use CommonHelperTrait;
    private $model;

    public function __construct(Gallery $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->active()->get();
    }

    public function getAll()
    {
        return $this->model->orderBy('id', 'desc')->paginate(Settings::PAGINATE);
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $row                       = new $this->model;
            $row->gallery_category_id  = $request->category;
            $row->upload_id            = $this->UploadImageCreate($request->image, 'backend/uploads/gallery');
            $row->status               = $request->status;
            $row->save();

            DB::commit();
            return $this->responseWithSuccess(___('alert.created_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function show($id)
    {
        return $this->model->find($id);
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $row                       = $this->model->findOrfail($id);
            $row->gallery_category_id  = $request->category;
            $row->upload_id            = $this->UploadImageUpdate($request->image, 'backend/uploads/gallery', $row->upload_id);
            $row->status               = $request->status;
            $row->save();

            DB::commit();
            return $this->responseWithSuccess(___('alert.updated_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $row = $this->model->find($id);
            $row->delete();
            DB::commit();
            return $this->responseWithSuccess(___('alert.deleted_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }
}
