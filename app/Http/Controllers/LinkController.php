<?php

namespace App\Http\Controllers;

use Lucid\Units\Controller;
use Illuminate\Http\Request;
use App\Features\AddLinkFeature;

class LinkController extends Controller
{
    public function add(Request $request)
    {
        return $this->serve(AddLinkFeature::class);
    }
}
