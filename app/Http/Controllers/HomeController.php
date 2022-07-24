<?php

namespace App\Http\Controllers;

use App\Models\Website;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * List web sites to subscribe
     */
    public function index()
    {
        $websites = Website::paginate(5);
        return view('home.index', compact('websites'));
    }

}
