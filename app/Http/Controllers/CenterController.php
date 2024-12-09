<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Http\Requests\StoreCenterRequest;
use App\Http\Requests\UpdateCenterRequest;
use App\Http\Resources\CenterResource;
use App\Models\Center;
use App\Models\File;
use App\Models\Image;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Litlife\Url\Url;

class CenterController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->input('status', StatusEnum::Accepted);

        $centers = Center::search($request->input('search'))
            ->where('status', $status)
            ->paginate(9)
            ->withQueryString();

        $centers->loadMissing('photo');

        if ($request->ajax())
        {
            return response()->json([
                'view' => view('centers.list', compact('centers'))->render()
            ]);
        }

        if ($request->expectsJson())
            return CenterResource::collection($centers);

        return view('centers.index', compact('centers'));
    }

    public function on_check(Request $request)
    {
        $centers = Center::search($request->input('search'))
            ->where('status', StatusEnum::OnReview)
            ->paginate(9)
            ->withQueryString();

        return CenterResource::collection($centers);
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
        $user = Auth::user();

        $center = Center::make($request->validated());
        $center->creator()->associate(Auth::user());
        $center->statusSentForReview();
        $center->save();

        $user->centers()->attach($center, ['roleable_type' => Center::class]);

        foreach ($request->get('photo') as $photo) {

            $disk = Storage::disk('public');

            //dd($disk->getDriver()->readStream($photo));

            $stream = $disk->getDriver()->readStream($photo);

            $photo = new Image;
            $photo->openImage($stream);
            $photo->storage = config('filesystems.default');
            $photo->name = Url::fromString($photo)->getBasename();
            $photo->save();

            $user->photo_id = $photo->id;
            $user->save();
        }

        foreach ($request->get('files') as $uploadedFile) {

            $disk = Storage::disk('public');
            $stream = $disk->getDriver()->readStream($uploadedFile);

            $file = new File;
            $file->name = Url::fromString($uploadedFile)->getBasename();
            $extension = Url::fromString($uploadedFile)->getExtension();
            $file->extension = $extension;
            $file->open($stream, $extension);
            $center->files()->save($file);
        }

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
    public function show(Request $request, Center $center)
    {
        $center->loadMissing('photo', 'files');

        if ($request->expectsJson())
            return new CenterResource($center);

        return view('centers.show', compact('center'));
    }

    public function edit(Center $center)
    {
        return view('centers.edit', compact('center'));
    }

    public function update(UpdateCenterRequest $request, Center $center)
    {
        $center->fill($request->validated());

        // Обработка фото (если новое фото загружено)
        if ($request->hasFile('photo')) {
            if ($center->photo instanceof Image)
                $center->photo->delete();

            $photo = new Image;
            $photo->openImage($request->file('photo')->getRealPath());
            $photo->storage = config('filesystems.default');
            $photo->name = $request->file('photo')->getClientOriginalName();
            $photo->save();

            $center->photo_id = $photo->id;
        }

        $center->save();

        return redirect()
            ->route('centers.show', $center->id)
            ->with('success', 'Профиль центра обновлен.');
    }

    public function editDetails(Center $center)
    {
        return view('centers.edit', compact('center'));
    }

    public function updateDetails(UpdateCenterRequest $request, Center $center)
    {
        $center->fill($request->validated());

        $center->save();

        return redirect()
            ->route('centers.details.edit', $center->id)
            ->with('success', 'Профиль центра обновлен.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Center $center)
    {
        //
    }


    /**
     * @throws AuthorizationException
     */
    public function approve(Center $center): JsonResponse
    {
        $this->authorize('approve', $center);

        $center->status = StatusEnum::Accepted;
        $center->save();
        $center->loadMissing('photo');

        Cache::forget('stats.centersCount');
        Cache::forget('stats.centersOnReviewCount');

        return response()
            ->json([
                'center' => new CenterResource($center),
                'message' => 'Центр одобрен'
            ]);
    }

    /**
     * @throws AuthorizationException
     */
    public function reject(Center $center): JsonResponse
    {
        $this->authorize('reject', $center);

        $center->status = StatusEnum::Rejected;
        $center->save();
        $center->loadMissing('photo');

        Cache::forget('stats.centersCount');
        Cache::forget('stats.centersOnReviewCount');

        return response()
            ->json([
                'center' => new CenterResource($center),
                'message' => 'Центр отклонен'
            ]);
    }
}
