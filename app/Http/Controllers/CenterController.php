<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCenterRequest;
use App\Http\Requests\UpdateCenterRequest;
use App\Models\Center;

class CenterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('center.index');
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
    public function store(StoreCenterRequest $request)
    {
        $center = Center::create($request->validated());

        return redirect()->route('centers.index')->with('success', 'Центр успешно добавлен!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Center $center)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Center $center)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCenterRequest $request, Center $center)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Center $center)
    {
        //
    }
}
