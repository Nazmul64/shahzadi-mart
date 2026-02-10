<?php

namespace App\Http\Controllers\Saller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SallerController extends Controller
{
    public  function saller_dashboard(){
        return view('saller.index');
    }
}
