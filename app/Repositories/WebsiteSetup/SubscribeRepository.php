<?php

namespace App\Repositories\WebsiteSetup;

use App\Enums\Settings;
use App\Interfaces\WebsiteSetup\SubscribeInterface;
use App\Models\WebsiteSetup\Subscribe;

class SubscribeRepository implements SubscribeInterface{

    private $model;

    public function __construct(Subscribe $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->orderBy('id','desc')->paginate(Settings::PAGINATE);
    }

}
