<?php

namespace Modules\MainApp\Http\Interfaces;

interface UserInterface
{
    public function show($id);

    public function profileUpdate($request, $id);

    public function passwordUpdate($request, $id);
}
