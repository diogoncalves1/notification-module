<?php
namespace App\Http\Controllers\Backend;

class HomeController
{
    public function index()
    {
        return view('admin.index');
    }
}
