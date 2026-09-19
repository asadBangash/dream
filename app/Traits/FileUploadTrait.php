<?php

namespace App\Traits;

use App\Models\Upload;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

trait FileUploadTrait
{

    public $site_local_path = 'storage/';

    public function saveUpload($original, $name, $paths = [], $id = null)
    {
        try {
            if ($id) {
                $upload = Upload::find($id);
            } else {
                $upload = new Upload();
            }
            $upload->original = $original;
            $upload->paths = $paths;
            $upload->name = $name;
            $upload->save();
            return $upload;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function returnResponse($message, $status, $data = null)
    {
        return [
            'message' => $message,
            'status' => $status,
            'upload_id' => $data,
        ];
    }
    public function customReturnResponse($message, $status, $data = null)
    {
        return [
            'message' => $message,
            'status' => $status,
            'data' => $data,
        ];
    }

    public function saveToStorage($url, $file)
    {
        try {
            if (env('FILESYSTEM_DISK') == 's3') {
                Storage::disk('s3')->put($url, $file);
                return true;
            } else {
                Storage::disk('public')->put($url, $file);
                return true;
            }
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function uploadFile($image, $path, $image_sizes, $old_upload_id, $image_type = 'image')
    {
        try {
            if ($old_upload_id) {
                $is_delete = $this->deleteFile($old_upload_id, 'update');
                if (!$is_delete['status']) {
                    return ['status' => false, 'message' => $is_delete['message'], 'upload_id' => ''];
                }
            }
            // delete old uploaded images

            if ($image_type == 'file') {
                $file = $image;
                $fileName = $file->getClientOriginalName();
                $fileName = date('Y-m-d') . '-' . strtolower(Str::random(12)) . '-' . $fileName;
                if ($this->saveToStorage('uploads/' . $path . $fileName, File::get($file))) {
                    $upload = $this->saveUpload('uploads/' . $path . $fileName, $fileName, [], $old_upload_id);
                    if ($upload) {
                        return $this->returnResponse(___('alert.File_uploaded_successfully'), true, $upload->id);
                    } else {
                        return $this->returnResponse(___('alert.File_upload_failed'), false, null);
                    }
                } else {
                    return $this->returnResponse(___('alert.File_upload_failed'), false, null);
                }

            } elseif ($image_type == 'video') {

                $file = $image;
                $fileName = $file->getClientOriginalName();
                $fileName = date('Y-m-d') . '-' . strtolower(Str::random(12)) . '-' . $fileName;
                // video upload using s3 bucket or local storage

                if ($this->saveToStorage('uploads/' . $path . $fileName, File::get($file))) {
                    $upload = $this->saveUpload('uploads/' . $path . $fileName, $fileName, [], $old_upload_id);
                    if ($upload) {
                        return $this->returnResponse(___('alert.Video file uploaded successfully'), true, $upload->id);
                    } else {
                        return $this->returnResponse(___('alert.Video_file_upload_failed'), false, null);
                    }
                } else {
                    return $this->returnResponse(___('alert.Video_file_upload_failed'), false, null);
                }
            } else {
                $requestImage = $image;
                $info = getimagesize($image);
                $fileType = strtolower(image_type_to_extension($info[2]));
                $fileType = explode('.', $fileType);
                $fileType = $fileType[1];

                if ($fileType == 'jpg') {
                    $fileType = 'jpeg';
                }

                $convertMethod = 'imagecreatefrom' . $fileType;
                $directory = "uploads/$path";

                // for original images
                $originalImageName = $this->imageName('original', $fileType);
                $originalImageUrl = $directory . $originalImageName;
                $imageSaveToStorage = $this->imageSaveToStorage($convertMethod, $originalImageUrl, $requestImage, 'original', '', '');
                if (!$imageSaveToStorage) {
                    return [
                        'status' => false,
                        'message' => ___('alert.Image_upload_failed'),
                        'upload_id' => null,
                    ];
                }

                $all_url = [];

                foreach ($image_sizes as $key => $image_size) {
                    $imageName = $this->imageName(++$key, 'webp');
                    $imageUrl = $directory . $imageName;
                    $all_url[$image_size[1] . 'x' . $image_size[0]] = $imageUrl;
                    $multipleImageSaveToStorage = $this->imageSaveToStorage($convertMethod, $imageUrl, $requestImage, '', $image_size[1], $image_size[0]);
                    if (!$multipleImageSaveToStorage) {
                        return [
                            'status' => false,
                            'message' => ___('alert.Image_upload_failed'),
                            'upload_id' => null,
                        ];
                    }
                }

                $upload = $this->saveUpload($originalImageUrl, $originalImageName, $all_url, $old_upload_id);
                if ($upload) {
                    return $this->returnResponse(___('alert.Image_uploaded_successfully'), true, $upload->id);
                } else {
                    return $this->returnResponse(___('alert.Image_upload_failed'), false, null);
                }
            }
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => ___('alert.File upload failed'),
                'upload_id' => null,
            ];
        }
    }

    public function customUpload($image, $path)
    {

        try {
            $requestImage = $image;
            $info = getimagesize($image);
            $fileType = strtolower(image_type_to_extension($info[2]));
            $fileType = explode('.', $fileType);
            $fileType = $fileType[1];

            if ($fileType == 'jpg') {
                $fileType = 'jpeg';
            }

            $convertMethod = 'imagecreatefrom' . $fileType;
            $directory = "uploads/$path";

            // for original images
            $originalImageName = $this->imageName('original', $fileType);
            $originalImageUrl = $directory . $originalImageName;
            $imageSaveToStorage = $this->imageSaveToStorage($convertMethod, $originalImageUrl, $requestImage, 'original', '', '');
            if (@$imageSaveToStorage) {
                $data = [
                    'original' => $originalImageUrl,
                ];
                return $this->customReturnResponse(___('alert.Image_uploaded_successfully'), true, $data);
            } else {
                return $this->customReturnResponse(___('alert.Image_upload_failed'), false, null);
            }
        } catch (\Throwable $th) {
            return $this->customReturnResponse(___('alert.Image_upload_failed'), false, null);
        }

    }

    public function imageName($size, $fileType)
    {

        $purpose = substr(0, 20) . $size . '.' . $fileType;
        $purpose = str_replace(" ", "-", $purpose);
        $purpose = date('Y-m-d') . '-' . strtolower(Str::random(12)) . '-' . $purpose;

        return $purpose;
    }

    public function imageSaveToStorage($convertMethod, $imageUrl, $requestImage, $original, $height = "", $width = "")
    {
        try {
            if ($original == 'original') {
                $image = Image::make($convertMethod($requestImage))->encode('webp', 90)->stream();
            } else {
                if ($height == 80 && $width == 80) {
                    $image = Image::make($convertMethod($requestImage))->resize($width, $height)->encode('webp', 90)->stream();
                } else {
                    $image = Image::make($convertMethod($requestImage))->resize($width, $height, function ($constraint) {
                        $constraint->aspectRatio();
                    })->encode('webp', 90)->stream();
                }
            }
            if ($this->saveToStorage($imageUrl, $image->__toString())) {
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function removeStorage($path)
    {
        return str_replace('/storage', '', $path);
    }

    public function isFile(string $path = null)
    {
        if (env('FILESYSTEM_DISK') == 's3') {
            return Storage::disk('s3')->exists($path);
        } elseif (env('FILESYSTEM_DISK') == 'local') {
            return Storage::exists('public/' . $path);
        } else {
            return Storage::exists('public/' . $path);
        }
    }

    public function delete(string $path = null)
    {
        if ($this->isFile($path)) {
            if (env('FILESYSTEM_DISK') == 's3') {
                return Storage::disk('s3')->delete($path);
            } else {
                return Storage::delete('public/' . $path);
            }
        } else {
            return false;
        }
    }
    public function deleteFile($old_upload_id, $slug = "update")
    {
        try {
            $upload = Upload::find($old_upload_id);
            if (!$upload) {
                return [
                    'status' => true,
                    'message' => ___('alert.Image_deleted_successfully'),
                    'upload_id' => null,
                ];
            }

            $paths = @$upload->paths ?: [];
            array_push($paths, $upload->original);
            foreach ($paths as $path) {
                $this->delete($path);
            }

            if ($slug == "delete") {
                $upload->delete();
            }
            return [
                'status' => true,
                'message' => ___('alert.Image_deleted_successfully'),
                'upload_id' => null,
            ];
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'message' => ___('alert.Image_delete_failed'),
                'upload_id' => null,
            ];
        }
    }
}
