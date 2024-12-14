<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Http\Requests\StoreWebinarRequest;
use App\Http\Requests\UpdateWebinarRequest;
use App\Http\Resources\WebinarResource;
use App\Models\Webinar;
use Illuminate\Support\Facades\Auth;

class WebinarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $upcomingWebinars = Webinar::upcoming()->with('cover')->get();
        $endedWebinars = Webinar::ended()->with('cover')->simplePaginate(10);

        return view('webinars.index', compact('upcomingWebinars', 'endedWebinars'));
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
        $this->authorize('create');

        $user = Auth::user();

        $webinar = Webinar::make($request->validated());
        $webinar->creator()->associate(Auth::user());
        $webinar->status = StatusEnum::OnReview;
        $webinar->save();

        if ($request->expectsJson()) {
            return [
                'redirect_to' => route('webinars.show', compact('webinar')),
                'webinar' => new WebinarResource($webinar)
            ];
        } else
            return redirect()->route('webinars.index')
                ->with('success', 'Объявление успешно добавлено');
    }

    /**
     * Display the specified resource.
     */
    public function show(Webinar $webinar)
    {
        $this->authorize('show');

        return view('webinars.show');
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
        $this->authorize('update', $webinar);

        $webinar->fill($request->validated());
        $webinar->save();

        if ($request->expectsJson()) {
            return [
                'redirect_to' => route('webinars.show', compact('webinar')),
                'webinar' => new WebinarResource($webinar)
            ];
        } else
            return redirect()
                ->route('webinars.index')
                ->with('success', 'Объявление успешно обновлено');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Webinar $webinar)
    {
        $this->authorize('delete', $webinar);

        if ($webinar->trashed())
            $webinar->restore();
        else
            $webinar->delete();

        return new WebinarResource($webinar);
    }
}
