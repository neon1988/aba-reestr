<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWebinarRequest;
use App\Http\Requests\UpdateWebinarRequest;
use App\Models\Webinar;

class WebinarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('webinars.index');
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
    public function store(StoreWebinarRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Webinar $webinar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Webinar $webinar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWebinarRequest $request, Webinar $webinar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Webinar $webinar)
    {
        //
    }
}
