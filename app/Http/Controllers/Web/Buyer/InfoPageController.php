<?php

namespace App\Http\Controllers\Web\Buyer;

use App\Http\Controllers\Controller;

class InfoPageController extends Controller
{
    public function about()
    {
        return view('buyer.pages.about');
    }

    public function livraison()
    {
        return view('buyer.pages.livraison');
    }

    public function cgv()
    {
        return view('buyer.pages.cgv');
    }

    public function confidentialite()
    {
        return view('buyer.pages.confidentialite');
    }
}
