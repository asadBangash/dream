<?php

namespace App\Http\Controllers\Api\Student;

use App\Traits\ReturnFormatTrait;
use App\Http\Controllers\Controller;

class SchoolInfoAPIController extends Controller
{
    use ReturnFormatTrait;

    
    public function index()
    {
        try {
           
            $schoolInfo['school_name']      = setting('application_name');
            $schoolInfo['about']            = setting('school_about');
            $schoolInfo['phone']            = setting('phone');
            $schoolInfo['email']            = setting('email');
            $schoolInfo['address']          = setting('address');

            return $this->responseWithSuccess(___('alert.success'), $schoolInfo);

        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), $th->getMessage());
        }
    }
}
