<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FindController extends Controller
{
    public function index()
    {
    	return view('find_doc');
    }

    public function addCredits()
    {
    	return view('select_payment');
    }
}
