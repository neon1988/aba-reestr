<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Http\Requests\StoreBulletinRequest;
use App\Http\Requests\UpdateBulletinRequest;
use App\Models\Bulletin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BulletinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->input('status', StatusEnum::Accepted);

        $items = Bulletin::search($request->input('search'))
            ->where('status', $status)
            ->paginate(9)
            ->withQueryString();

        $items->loadMissing('creator.photo');

        if ($request->ajax())
        {
            return response()->json([
                'view' => view('bulletins.list', compact('items'))->render()
            ]);
        }

        if ($request->expectsJson())
            return BulletinResource::collection($items);

        return view('bulletins.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bulletins.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBulletinRequest $request)
    {
        $user = Auth::user();

        $bulletin = Bulletin::make($request->validated());
        $bulletin->creator()->associate(Auth::user());
        $bulletin->status = StatusEnum::Accepted;
        $bulletin->save();

        if ($request->expectsJson())
        {
            return [
                'redirect_to' => route('bulletins.show', compact('bulletin')),
                'center' => new BulletinResource($bulletin)
            ];
        }
        else
            return redirect()->route('bulletins.index')
                ->with('success', 'Объявление успешно добавлено');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bulletin $bulletin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bulletin $bulletin)
    {
        return view('bulletins.edit', compact('bulletin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBulletinRequest $request, Bulletin $bulletin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bulletin $bulletin)
    {
        //
    }
}
