<?php

namespace Modules\MainApp\Http\Repositories;

use PDO;
use App\Models\Tenant;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Modules\MainApp\Entities\Subscription;
use Modules\MainApp\Http\Interfaces\ReportInterface;

class ReportRepository implements ReportInterface
{
    use ReturnFormatTrait;
    private $model;

    public function __construct(Subscription $model)
    {
        $this->model = $model;
    }

    public function search($request)
    {
        try {
            $dates = explode(' - ', $request->dates);

            $start = date('Y-m-d 00:00:00', strtotime($dates[0]));
            $end   = date('Y-m-d 23:59:59', strtotime($dates[1]));

            $data['total'] = $this->model->whereBetween('created_at', [$start, $end])->sum('price');
            $data['subscriptions'] = $this->model->whereBetween('created_at', [$start, $end])->paginate(10);

            $data['dates'] = $request->dates;

            return $this->responseWithSuccess('', $data);
        } catch (\Throwable $th) {

            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }

    }

}
