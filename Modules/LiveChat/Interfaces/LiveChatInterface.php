<?php

namespace Modules\LiveChat\Interfaces;

use Illuminate\Http\Request;

interface LiveChatInterface
{
    public function model();

    public function store($request);

    public function update($request);

    public function readMessages($id);


    public function adminChatList($reqeust);
    public function studentChatList($reqeust);

    public function instructorChatList($reqeust);
}
