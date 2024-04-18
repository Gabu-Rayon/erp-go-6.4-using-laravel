<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemClassification;

class ItemClassificationCodeController extends Controller
{
    //
    public function index()
    {
        if (\Auth::user()->type == 'company') {
            $itemclassifications = ItemClassification::all();
            \Log::info($itemclassifications);
            return view('itemclassificationcode.index', compact('itemclassifications'));
        }
        return view('itemclassificationcode.index');
    }
}
