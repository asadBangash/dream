<?php

namespace App\Interfaces\Report;

interface DueFeesInterface
{
    public function search($request);
    public function assignedFeesTypes();
}
