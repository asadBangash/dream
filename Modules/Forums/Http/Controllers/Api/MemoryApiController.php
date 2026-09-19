<?php

namespace Modules\Forums\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use App\Traits\CommonHelperTrait;
use Modules\Forums\Entities\Memory;
use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Http\RedirectResponse;
use Maatwebsite\Excel\Cache\MemoryCache;
use Illuminate\Support\Facades\Validator;
use Modules\Forums\Entities\MemoryGallery;
use Modules\Forums\Transformers\Api\MemoryListResource;
use Modules\Forums\Transformers\Api\MemoryGalleryResource;

class MemoryApiController extends Controller
{
    use ApiReturnFormatTrait;
    use CommonHelperTrait;
    public function index()
    {

        $galleries = Memory::with('publisher:id,name,upload_id','feature_image:id,path','creator:id,name,upload_id')->withCount('galleries')->latest()->paginate(10);
        MemoryListResource::collection($galleries);
        return $this->responseWithSuccess('Galleries Posts',  $galleries, 200);
    }


    public function show($id)
    {

        $memory = Memory::findOrFail($id);
        $galleries = MemoryGallery::where('memory_id',$id)->with('image')->get();
        $data = MemoryGalleryResource::collection($galleries);
        return $this->responseWithSuccess('Galleries Images',  $data, 200);
    }


    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),
            [
                'title' => 'required|string|max:255',
                'gallery_images' => 'required|array',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);

            if($validate->fails()){
                return $this->responseWithError('Validation Errors', $validate->errors(), 422);
            }

            try{
             $upload_id  = $this->UploadImageCreate($request->image, 'backend/uploads/memory') ?? null;
            // Create a new post
            $memory = Memory::create([
                'title' => $request->title,
                'feature_image_id' => $upload_id,
                'published_by' => auth()->id(),
                'published_at' => Carbon::now(),
                'created_by' => auth()->id()
            ]);

            if($memory){
                foreach($request->gallery_images as $gallery){
                    $gallery_id  = $this->UploadImageCreate($gallery, 'backend/uploads/memory/gallery') ?? null;

                    $new_gallery = new MemoryGallery();
                    $new_gallery->memory_id = $memory->id;
                    $new_gallery->gallery_image_id = $gallery_id;
                    $new_gallery->save();
                }
            }
            return $this->responseWithSuccess('Memory Store',  $memory, 200);
        } catch (\Throwable $th) {
            return $this->responseWithError('Memory Store Failed',  $th->getMessage(), 400);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('forums::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
