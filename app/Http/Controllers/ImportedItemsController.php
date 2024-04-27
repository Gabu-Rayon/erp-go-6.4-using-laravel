<?php

namespace App\Http\Controllers;

use App\Models\ImportedItems;
use Illuminate\Http\Request;

class ImportedItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $importedItems = ImportedItems::all();
            return view('importeditems.index', compact('importedItems'));
        } catch (\Exception $e) {
            \Log::error($e);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('importeditems.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $importedItem = ImportedItems::find($id);
        return view('importeditems.show', compact('importedItem'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ImportedItems $importedItems)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ImportedItems $importedItems)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ImportedItems $importedItems)
    {
        //
    }
}
