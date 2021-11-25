<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactsController extends Controller
{
    public function list(Request $request)
    {
        return view('contacts', ['contacts' => $request->user()->contacts->toArray()]);
    }
}
