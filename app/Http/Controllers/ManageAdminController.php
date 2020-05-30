<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManageAdminController extends Controller
{
    //
    public function fetch()
    {
    	return view('admin');
    }
}
