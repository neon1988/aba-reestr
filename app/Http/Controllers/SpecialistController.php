<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSpecialistRequest;
use App\Http\Requests\UpdateSpecialistRequest;
use App\Models\Specialist;
use Illuminate\Support\Facades\Auth;

class SpecialistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $specialists = Specialist::active()->paginate(9);

        return view('specialist.index', compact('specialists'));
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
        $specialist = Specialist::make($request->validated());
        $specialist->creator()->associate(Auth::user());
        $specialist->statusSentForReview();
        $specialist->save();

        return redirect()->route('specialists.show', compact('specialist'))
            ->with('success', 'Специалист успешно добавлен!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Specialist $specialist)
    {
        return view('specialist.show', compact('specialist'));
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
