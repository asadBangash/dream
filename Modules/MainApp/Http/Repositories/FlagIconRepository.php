<?php

namespace Modules\MainApp\Http\Repositories;

use App\Models\FlagIcon;
use App\Traits\CommonHelperTrait;
use Modules\MainApp\Http\Interfaces\FlagIconInterface;

class FlagIconRepository implements FlagIconInterface
{
    use CommonHelperTrait;
    private $model;

    public function __construct(FlagIcon $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return FlagIcon::all();
    }

}
