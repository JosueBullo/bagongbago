<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerPanelController extends Controller
{
    public function index()
    {
        return view('Customer.customerindex');
    }
}
