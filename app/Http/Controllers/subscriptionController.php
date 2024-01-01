<?php

namespace App\Http\Controllers;

use App\Models\clients;
use App\Models\User;
use Illuminate\Http\Request;

class subscriptionController extends Controller
{
    public function index()
    {
        $data = clients::all();
        return view('frontend.admin.pages.subscription.index')->with(['data' => $data]);
    }
    public function active()
    {
        return view('frontend.admin.pages.subscription.active');
    }
    public function pending()
    {
        return view('frontend.admin.pages.subscription.pending');
    }
    public function expired()
    {
        return view('frontend.admin.pages.subscription.expired');
    }
}
