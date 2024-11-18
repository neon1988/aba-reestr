<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCenterRequest;
use App\Http\Requests\UpdateCenterRequest;
use App\Http\Resources\CenterResource;
use App\Models\Center;
use App\Models\File;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Litlife\Url\Url;

class CenterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $centers = Center::active()->paginate(9);

        return view('center.index', compact('centers'));
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
        $center = Center::make($request->validated());
        $center->creator()->associate(Auth::user());
        $center->statusSentForReview();
        $center->save();

        $photo = new Image;
        $photo->openImage($request->file('photo')->getRealPath());
        $photo->storage = config('filesystems.default');
        $photo->name = $request->file('photo')->getClientOriginalName();
        $photo->save();

        $center->photo_id = $photo->id;
        $center->save();

        $file = new File;
        $file->name = $request->file('file')->getClientOriginalName();
        $extension = Url::fromString($request->file('file')->getClientOriginalName())->getExtension();
        $file->extension = $extension;
        $file->open($request->file('file')->getRealPath());
        $center->files()->save($file);

        if ($request->expectsJson())
        {
            return [
                'redirect_to' => route('centers.show', compact('center')),
                'center' => new CenterResource($center)
            ];
        }
        else
            return redirect()->route('centers.show', compact('center'))
                ->with('success', 'Центр успешно добавлен!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Center $center)
    {
        return view('center.show', compact('center'));
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
