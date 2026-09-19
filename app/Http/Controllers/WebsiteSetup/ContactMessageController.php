<?php

namespace App\Http\Controllers\WebsiteSetup;

use App\Enums\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WebsiteSetup\Contact;
use Illuminate\Support\Facades\Schema;
use App\Repositories\WebsiteSetup\ContactMessageRepository;

class ContactMessageController extends Controller
{
    private $repo;

    function __construct(ContactMessageRepository $repo)
    {
        if (!Schema::hasTable('settings') && !Schema::hasTable('users')  ) {
            abort(400);
        } 
        $this->repo                  = $repo;
    }

    public function index()
    {
        $data['contact'] = $this->repo->all();
        $data['title'] = ___('settings.contact_message');
        return view('website-setup.contact-message.index', compact('data'));
    }
}
