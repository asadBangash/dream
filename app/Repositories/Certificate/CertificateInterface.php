<?php

namespace App\Repositories\Certificate;

interface CertificateInterface
{

    public function all();

    public function getPaginateAll();

    public function store($request);

    public function search($request);

    public function show($id);

    public function update($request, $id);

    public function destroy($id);

    public function generateSearch($request);

}
