<?php

namespace App\Http\Controllers;

use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * List web sites to subscribe
     */
    public function index()
    {
        $websites = Cache::remember('websites_' . request()->page, 120, function() {
            return Website::paginate(5);
        });

        // $websites = Website::paginate(5);
        return view('home.index', compact('websites'));
    }

}
