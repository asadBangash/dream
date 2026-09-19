<?php

namespace App\Repositories\WebsiteSetup;

use App\Enums\Settings;
use App\Models\GalleryCategory;
use App\Traits\CommonHelperTrait;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Interfaces\WebsiteSetup\GalleryCategoryInterface;
use App\Models\GalleryCategoryTranslate;

class GalleryCategoryRepository implements GalleryCategoryInterface
{

    use ReturnFormatTrait;
    use CommonHelperTrait;
    private $model;
    private $trans;

    public function __construct(GalleryCategory $model , GalleryCategoryTranslate $trans)
    {
        $this->model = $model;
        $this->trans = $trans;
    }

    public function all()
    {
        return $this->model->active()->get();
    }

    public function translates($page_id)
    {
        return $this->trans->where('gallery_category_id',$page_id)->get()->groupBy('locale');
    }

    public function getAll()
    {
        return $this->model->orderBy('id', 'desc')->paginate(Settings::PAGINATE);
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $row                   = new $this->model;
            $row->name             = $request->name;
            $row->status           = $request->status;
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
            $row                   = $this->model->findOrfail($id);
            $row->name             = $request->name;
            $row->status           = $request->status;
            $row->save();

            DB::commit();
            return $this->responseWithSuccess(___('alert.updated_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function translateUpdate($request, $id)
    {
        DB::beginTransaction();
        try {
            $delete_old = $this->trans->where('gallery_category_id',$id)->delete();
            $cat = $this->show($id);

            foreach($request->name as $key => $name){
                $row                   = new $this->trans;
                $row->gallery_category_id        = $id ;
                $row->locale           = $key;
                $row->name             = $name;
                $row->save();
            }
            DB::commit();
            return $this->responseWithSuccess(___('alert.updated_successfully'), []);
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $row = $this->model->with('images')->find($id);
            $image = json_decode($row['images']);
            $length = count($image);
            for ($i = 0; $i < $length; $i++) {
                $this->UploadImageDelete($image[$i]->upload_id);
            }
            $row->delete();
            DB::commit();
            return $this->responseWithSuccess(___('alert.deleted_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }
}
