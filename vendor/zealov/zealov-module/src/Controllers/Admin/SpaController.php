<?php


namespace Zealov\Controllers\Admin;

use Illuminate\Routing\Controller;

class SpaController extends Controller
{
    public function index(){
        return view('zealov::admin.index');
    }
}
