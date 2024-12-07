<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Http\Requests\StoreSpecialistRequest;
use App\Http\Requests\UpdateSpecialistLocationAndWorkRequest;
use App\Http\Requests\UpdateSpecialistPhotoRequest;
use App\Http\Requests\UpdateSpecialistRequest;
use App\Http\Resources\SpecialistResource;
use App\Models\Country;
use App\Models\File;
use App\Models\Image;
use App\Models\Specialist;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
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

        if ($request->ajax()) {
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
        $specialist->status = StatusEnum::OnReview;
        $specialist->save();

        $user->specialists()->attach($specialist);

        if (count($request->get('photo')) > 0)
        {
            foreach ($request->get('photo') as $photo) {

                $disk = Storage::disk('public');

                //dd($disk->getDriver()->readStream($photo));

                $stream = $disk->getDriver()->readStream($photo);

                $photo = new Image;
                $photo->openImage($stream);
                $photo->storage = config('filesystems.default');
                $photo->name = Url::fromString($photo)->getBasename();
                $photo->save();

                $specialist->photo_id = $photo->id;
                $specialist->save();
                $user->photo_id = $photo->id;
                $user->save();
            }
        } elseif ($user->photo) {
            $specialist->photo_id = $user->photo->id;
            $specialist->save();
        }

        foreach ($request->get('files') as $uploadedFile) {

            $disk = Storage::disk('public');
            $stream = $disk->getDriver()->readStream($uploadedFile);

            $file = new File;
            $file->name = Url::fromString($uploadedFile)->getBasename();
            $extension = Url::fromString($uploadedFile)->getExtension();
            $file->extension = $extension;
            $file->open($stream, $extension);
            $specialist->files()->save($file);
        }

        if (is_array($request->get('additional_courses')))
        {
            foreach ($request->get('additional_courses') as $uploadedFile) {

                $disk = Storage::disk('public');
                $stream = $disk->getDriver()->readStream($uploadedFile);

                $file = new File;
                $file->name = Url::fromString($uploadedFile)->getBasename();
                $extension = Url::fromString($uploadedFile)->getExtension();
                $file->extension = $extension;
                $file->open($stream, $extension);
                $specialist->files()->save($file);
            }
        }

        if ($request->expectsJson()) {
            return [
                'redirect_to' => route('specialists.show', compact('specialist')),
                'specialist' => new SpecialistResource($specialist)
            ];
        } else
            return redirect()->route('specialists.show', compact('specialist'))
                ->with('success', 'Специалист успешно добавлен!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Specialist $specialist)
    {
        $specialist->loadMissing('files');

        if ($request->expectsJson())
            return new SpecialistResource($specialist);

        return view('specialists.show', compact('specialist'));
    }

    public function edit(Specialist $specialist)
    {
        $user = $specialist->users()->first();
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
            ->route('specialists.edit', $specialist->id)
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

        if ($request->expectsJson()) {
            return new SpecialistResource($specialist);
        } else {
            return redirect()
                ->route('specialists.show', $specialist->id)
                ->with('success', 'Профиль специалиста обновлен.');
        }
    }

    public function showLocationAndWork(Specialist $specialist)
    {
        $countries = Country::orderBy('name', 'asc')->get();

        return view('specialists.location_and_work', compact('specialist', 'countries'));
    }

    public function updateLocationAndWork(UpdateSpecialistLocationAndWorkRequest $request, Specialist $specialist)
    {
        $specialist->fill($request->validated());
        $specialist->save();

        if ($request->expectsJson()) {
            return new SpecialistResource($specialist);
        } else {
            return redirect()
                ->route('specialists.location_and_work', $specialist->id)
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


    // Метод для отображения образования и документов
    public function educationAndDocuments(Specialist $specialist)
    {
        return view('specialists.education_and_documents', compact('specialist'));
    }

    // Метод для отображения счетов и документов оплаты
    public function billingAndPaymentDocuments(Specialist $specialist)
    {
        return view('specialists.billing_and_payment_documents', compact('specialist'));
    }
}
