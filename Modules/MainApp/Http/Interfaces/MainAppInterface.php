<?php

namespace Modules\MainApp\Http\Interfaces;

interface MainAppInterface
{
    public function contact($request);
    
    public function subscribe($request);

    public function getContacts();
    public function getSubscribes();
}
