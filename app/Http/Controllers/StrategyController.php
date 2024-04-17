<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Strategy;

class StrategyController extends Controller
{
    public function index()
    {
        $strategies = Strategy::all();
        return view('metrics', ['strategy' => $strategies]);
    }
}
