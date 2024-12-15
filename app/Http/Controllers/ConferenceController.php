<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Http\Requests\StoreConferenceRequest;
use App\Http\Requests\UpdateConferenceRequest;
use App\Http\Resources\ConferenceResource;
use App\Models\Conference;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class ConferenceController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $upcoming = Conference::upcoming()->with('cover')->get();
        $ended = Conference::ended()->with('cover')->simplePaginate(10);

        return view('conferences.index', compact('upcoming', 'ended'));
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
    public function store(StoreConferenceRequest $request)
    {
        $this->authorize('create');

        $user = Auth::user();

        $conference = Conference::make($request->validated());
        $conference->creator()->associate($user);
        $conference->status = StatusEnum::Accepted;
        $conference->save();

        if ($request->expectsJson()) {
            return [
                'redirect_to' => route('conferences.show', compact('conference')),
                'conference' => new ConferenceResource($conference)
            ];
        } else
            return redirect()->route('conferences.index')
                ->with('success', 'Конференция успешно добавлена');
    }

    /**
     * Display the specified resource.
     */
    public function show(Conference $conference)
    {
        $this->authorize('view', $conference);

        return view('conferences.show', ['item' => $conference]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Conference $conference)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateConferenceRequest $request, Conference $conference)
    {
        $this->authorize('update', $conference);

        $conference->fill($request->validated());
        $conference->save();

        if ($request->expectsJson()) {
            return [
                'redirect_to' => route('conferences.show', compact('conference')),
                'conference' => new ConferenceResource($conference)
            ];
        } else
            return redirect()
                ->route('conferences.index')
                ->with('success', 'Конференция обновлена');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Conference $conference)
    {
        $this->authorize('delete', $conference);

        if ($conference->trashed())
            $conference->restore();
        else
            $conference->delete();

        return new ConferenceResource($conference);
    }
}
