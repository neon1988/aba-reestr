<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorksheetRequest;
use App\Http\Requests\UpdateWorksheetRequest;
use App\Models\Webinar;
use App\Models\Worksheet;
use Illuminate\Contracts\View\View;

class WorksheetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $items = Worksheet::with('cover', 'file', 'creator')
            ->simplePaginate(10);

        return view('worksheets.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWorksheetRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Worksheet $worksheet)
    {
        return view('worksheets.show', ['item' => $worksheet]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Worksheet $worksheet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWorksheetRequest $request, Worksheet $worksheet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Worksheet $worksheet)
    {
        //
    }
}
