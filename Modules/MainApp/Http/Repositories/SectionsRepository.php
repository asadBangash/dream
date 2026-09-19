<?php

namespace Modules\MainApp\Http\Repositories;

use App\Models\Slider;
use App\Enums\Settings;
use Illuminate\Support\Facades\DB;
use App\Traits\CommonHelperTrait;
use App\Traits\ReturnFormatTrait;
use Modules\MainApp\Entities\Sections;
use Modules\MainApp\Http\Interfaces\SectionsInterface;

class SectionsRepository implements SectionsInterface{

    use ReturnFormatTrait;
    use CommonHelperTrait;
    private $model;

    public function __construct(Sections $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->get();
    }

    public function getAll()
    {
        return $this->model->paginate(Settings::PAGINATE);
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
            if($request->name != '')
                $row->name             = $request->name;
            if($request->image != '')
                $row->upload_id        = $this->UploadImageUpdate($request->image, 'saas-frontend/img/banner', $row->upload_id);
            if($request->description != '')
                $row->description      = $request->description;
             
            if($row->key == 'social_links'){ // ----------------------------- social_links -----------------------------
                $data =  [];
                foreach ($request->data['name'] as $key => $value) {
                    $data[] =  [
                        'name' => $value,
                        'icon' => $request->data['icon'][$key],
                        'link' => $request->data['link'][$key],
                    ];
                }
                $row->data = $data;
            }
            
            elseif($row->key == 'services'){ // ----------------------------- services -----------------------------
                $data =  [];
                foreach ($request->data['title'] as $key => $value) {
                    $data[] =  [
                        'icon'        => array_key_exists('icon', $request->data) ? ( array_key_exists($key,$request->data['icon']) ? $this->UploadImageCreate($request->data['icon'][$key], 'saas-frontend/img/icon') : $row->data[$key]['icon'] ) : $row->data[$key]['icon'],
                        'title'       => $value,
                        'description' => $request->data['description'][$key],
                    ];
                }
                $row->data = $data;
            }
            
            elseif($row->key == 'contact'){ // ----------------------------- contact -----------------------------
                $data        =  [];
                foreach ($request->data as $key => $value) {
                    $data[]  = $value;
                }
                $row->data   = $data;
            }
            
            else
                $row->data = [];

            $row->save();

            DB::commit();
            return $this->responseWithSuccess(___('alert.updated_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }
}
