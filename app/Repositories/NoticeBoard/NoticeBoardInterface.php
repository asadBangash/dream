<?php

namespace App\Repositories\NoticeBoard;

interface NoticeBoardInterface
{
    public function all();

    public function getPaginateAll();

    public function store($request);

    public function search($request);

    public function show($id);

    public function update($request, $id);
}
