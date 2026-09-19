<?php

namespace Modules\MainApp\Http\Interfaces;

interface SubscriptionInterface
{

    public function all();

    public function getAll();

    public function show($id);

    public function approved($request, $id);

    public function store($request);

    public function reject($id);

    public function destroy($id);
}
