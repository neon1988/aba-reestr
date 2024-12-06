<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Http\Requests\StoreSpecialistRequest;
use App\Http\Requests\UpdateSpecialistPhotoRequest;
use App\Http\Requests\UpdateSpecialistRequest;
use App\Http\Resources\SpecialistResource;
use App\Models\File;
use App\Models\Image;
use App\Models\Specialist;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Litlife\Url\Url;

class SpecialistController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->input('status', StatusEnum::Accepted);

        $specialists = Specialist::search($request->input('search'))
            ->where('status', $status)
            ->paginate(9)
            ->withQueryString();

        $specialists->loadMissing('photo');

        if ($request->ajax())
        {
            return response()->json([
                'view' => view('specialists.list', compact('specialists'))->render()
            ]);
        }
        if ($request->expectsJson())
            return SpecialistResource::collection($specialists);

        return view('specialists.index', compact('specialists'));
    }

    public function on_check(Request $request)
    {
        $specialists = Specialist::search($request->input('search'))
            ->where('status', StatusEnum::OnReview)
            ->paginate(9)
            ->withQueryString();

        return SpecialistResource::collection($specialists);
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
        $user = Auth::user();

        if ($user->specialists()->first())
            abort(403);

        if ($user->centers()->first())
            abort(403);

        $specialist = Specialist::make($request->validated());
        $specialist->creator()->associate(Auth::user());
        $specialist->statusPrivate();
        $specialist->save();

        $user->specialists()->attach($specialist);

        if ($request->hasFile('photo'))
        {
            $photo = new Image;
            $photo->openImage($request->file('photo')->getRealPath());
            $photo->storage = config('filesystems.default');
            $photo->name = $request->file('photo')->getClientOriginalName();
            $photo->save();

            $specialist->photo_id = $photo->id;
            $specialist->save();
        }

        if ($request->hasFile('file'))
        {
            $file = new File;
            $file->name = $request->file('file')->getClientOriginalName();
            $extension = Url::fromString($request->file('file')->getClientOriginalName())->getExtension();
            $file->extension = $extension;
            $file->open($request->file('file')->getRealPath());
            $specialist->files()->save($file);
        }

        if ($request->expectsJson())
        {
            return [
                'redirect_to' => route('specialists.show', compact('specialist')),
                'specialist' => new SpecialistResource($specialist)
            ];
        }
        else
            return redirect()->route('specialists.show', compact('specialist'))
                ->with('success', 'Специалист успешно добавлен!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Specialist $specialist)
    {
        $specialist->loadMissing('photo', 'files');

        if ($request->expectsJson())
            return new SpecialistResource($specialist);

        return view('specialists.show', compact('specialist'));
    }

    public function edit(Specialist $specialist)
    {
        return view('specialists.edit', compact('specialist'));
    }

    public function update(UpdateSpecialistRequest $request, Specialist $specialist)
    {
        $specialist->fill($request->validated());

        // Обработка фото (если новое фото загружено)
        if ($request->hasFile('photo')) {
            if ($specialist->photo instanceof Image)
                $specialist->photo->delete();

            $photo = new Image;
            $photo->openImage($request->file('photo')->getRealPath());
            $photo->storage = config('filesystems.default');
            $photo->name = $request->file('photo')->getClientOriginalName();
            $photo->save();

            $specialist->photo_id = $photo->id;
        }

        $specialist->save();

        return redirect()
            ->route('specialists.show', $specialist->id)
            ->with('success', 'Профиль специалиста обновлен.');
    }

    public function updatePhoto(UpdateSpecialistPhotoRequest $request, Specialist $specialist)
    {
        $specialist->fill($request->validated());

        // Обработка фото (если новое фото загружено)
        if ($request->hasFile('photo')) {
            if ($specialist->photo instanceof Image)
                $specialist->photo->delete();

            $photo = new Image;
            $photo->openImage($request->file('photo')->getRealPath());
            $photo->storage = config('filesystems.default');
            $photo->name = $request->file('photo')->getClientOriginalName();
            $photo->save();

            $specialist->photo_id = $photo->id;
        }

        $specialist->save();
        $specialist->refresh();
        $specialist->load(['photo']);

        if ($request->expectsJson())
        {
            return new SpecialistResource($specialist);
        }
        else
        {
            return redirect()
                ->route('specialists.show', $specialist->id)
                ->with('success', 'Профиль специалиста обновлен.');
        }
    }

    public function updateLocationAndWork(UpdateSpecialistLocationAndWorkRequest $request, Specialist $specialist)
    {
        $specialist->fill($request->validated());
        $specialist->save();

        if ($request->expectsJson())
        {
            return new SpecialistResource($specialist);
        }
        else
        {
            return redirect()
                ->route('specialists.show', $specialist->id)
                ->with('success', 'Профиль специалиста обновлен.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Specialist $specialist)
    {
        //
    }

    /**
     * @throws AuthorizationException
     */
    public function approve(Specialist $specialist): JsonResponse
    {
        $this->authorize('approve', $specialist);

        $specialist->status = StatusEnum::Accepted;
        $specialist->save();
        $specialist->loadMissing('photo');

        Cache::forget('stats.specialistsCount');
        Cache::forget('stats.specialistsOnReviewCount');

        return response()
            ->json([
                'specialist' => new SpecialistResource($specialist),
                'message' => 'Специалист подтвержден'
            ]);
    }

    /**
     * @throws AuthorizationException
     */
    public function reject(Specialist $specialist): JsonResponse
    {
        $this->authorize('reject', $specialist);

        $specialist->status = StatusEnum::Rejected;
        $specialist->save();
        $specialist->loadMissing('photo');

        Cache::forget('stats.specialistsCount');
        Cache::forget('stats.specialistsOnReviewCount');

        return response()
            ->json([
                'specialist' => new SpecialistResource($specialist),
                'message' => 'Специалист отклонен'
            ]);
    }
}
