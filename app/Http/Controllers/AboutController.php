<?php

namespace App\Http\Controllers;

use App\Models\AboutVideo;

class AboutController extends Controller
{
    public function index()
    {
        return view('pages.about');
    }


    public function staff()
    {
        return view('pages.staff');
    }

    public function partenary()
    {
        return view('pages.partenary');
    }

    public function sponsors()
    {
        return view('pages.sponsors');
    }

    public function parrain()
    {
        return view('parrain.index');
    }



    public function faq()
    {
        return view('pages.faq');
    }

    public function stat()
    {
        return view('pages.stat');
    }
}
