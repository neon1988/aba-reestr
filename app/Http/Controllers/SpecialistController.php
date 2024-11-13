<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSpecialistRequest;
use App\Http\Requests\UpdateSpecialistRequest;
use App\Models\Specialist;

class SpecialistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('specialist.index');
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
    public function store(StoreSpecialistRequest $request)
    {
        $specialist = Specialist::create($request->validated());

        return redirect()->route('centers.index')->with('success', 'Специалист успешно добавлен!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Specialist $specialist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Specialist $specialist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSpecialistRequest $request, Specialist $specialist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Specialist $specialist)
    {
        //
    }
}
