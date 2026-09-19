<?php

namespace App\Interfaces\ParentPanel;

interface DashboardInterface
{
    public function index();
    
    public function search($request);
}
