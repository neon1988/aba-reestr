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
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
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
            ->orderBy('created_at', 'desc')
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
            ->orderBy('created_at', 'desc')
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
            abort(403, 'Специалист уже привязан');

        if ($user->centers()->first())
            abort(403, 'Центр уже привязан');

        $specialist = DB::transaction(function () use ($user, $request) {

            $specialist = Specialist::make($request->validated());
            $specialist->creator()->associate(Auth::user());
            $specialist->status = StatusEnum::OnReview;
            $specialist->save();

            $user->specialists()->attach($specialist);

            if ($upload = $request->get('photo')) {
                if ($file = File::find($upload['id'])) {
                    if ($file->storage == 'temp' and Auth::user()->is($file->creator)) {
                        $file->storage = 'public';
                        $file->save();
                        $user->photo_id = $file->id;
                        $user->save();
                        $specialist->photo_id = $file->id;
                        $specialist->save();
                    }
                }
            }

            foreach ($request->get('files', []) as $upload) {
                if ($file = File::find($upload['id'])) {
                    if ($file->storage == 'temp' and Auth::user()->is($file->creator)) {
                        $file->storage = 'public';
                        $file->save();
                        $specialist->files()->attach($file);
                    }
                }
            }

            foreach ($request->get('additional_courses', []) as $upload) {
                if ($file = File::find($upload['id'])) {
                    if ($file->storage == 'temp' and Auth::user()->is($file->creator)) {
                        $file->storage = 'public';
                        $file->save();
                        $specialist->files()->attach($file);
                    }
                }
            }

            return $specialist;
        });

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
        $specialist->loadMissing('photo', 'files');

        if ($request->expectsJson())
            return new SpecialistResource($specialist);

        return view('specialists.show', compact('specialist'));
    }

    public function edit(Specialist $specialist)
    {
        return view('specialists.edit', compact('specialist'));
    }

    public function update2(UpdateSpecialistRequest $request, Specialist $specialist)
    {
        $specialist = DB::transaction(function () use ($specialist, $request) {

            $specialist->fill($request->validated());

            $user = $specialist->users()->first();

            if ($user instanceof User)
                $user->fill($request->validated());

            if ($upload = $request->get('photo')) {
                if ($file = File::find($upload['id'])) {
                    if ($file->storage == 'temp' and Auth::user()->is($file->creator)) {
                        $file->storage = 'public';
                        $file->save();

                        if ($specialist->photo instanceof Image)
                            $specialist->photo->delete();

                        if ($user instanceof User)
                        {
                            $user->photo_id = $file->id;
                            $user->save();
                        }
                        $specialist->photo_id = $file->id;
                        $specialist->save();
                    }
                }
            }

            $specialist->save();

            return $specialist;
        });

        return redirect()
            ->route('specialists.edit', $specialist->id)
            ->with('success', 'Профиль специалиста обновлен.');
    }

    public function update(UpdateSpecialistRequest $request, Specialist $specialist)
    {
        $specialist = DB::transaction(function () use ($specialist, $request) {

            $specialist->fill($request->validated());

            $user = $specialist->users()->first();

            if ($user instanceof User)
                $user->fill($request->validated());

            if ($upload = $request->get('photo')) {
                if ($file = File::find($upload['id'])) {
                    if ($file->storage == 'temp' and Auth::user()->is($file->creator)) {
                        $file->storage = 'public';
                        $file->save();
                        $user->photo_id = $file->id;
                        $specialist->photo_id = $file->id;
                    }
                }
            }

            foreach ($request->get('files', []) as $upload) {
                if ($file = File::find($upload['id'])) {
                    if ($file->storage == 'temp' and Auth::user()->is($file->creator)) {
                        $file->storage = 'public';
                        $file->save();
                        $specialist->files()->attach($file);
                    }
                }
            }

            foreach ($request->get('additional_courses', []) as $upload) {
                if ($file = File::find($upload['id'])) {
                    if ($file->storage == 'temp' and Auth::user()->is($file->creator)) {
                        $file->storage = 'public';
                        $file->save();
                        $specialist->files()->attach($file);
                    }
                }
            }

            $specialist->save();

            if ($user instanceof User)
                $user->save();

            return $specialist;
        });

        if ($request->expectsJson())
            return new SpecialistResource($specialist);
        else
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

        return view('specialists.location-and-work', compact('specialist', 'countries'));
    }

    public function updateLocationAndWork(UpdateSpecialistLocationAndWorkRequest $request, Specialist $specialist)
    {
        $specialist->fill($request->validated());
        $specialist->save();

        if ($request->expectsJson()) {
            return new SpecialistResource($specialist);
        } else {
            return redirect()
                ->route('specialists.location-and-work', $specialist->id)
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
        $documents = $specialist->files()->get();

        return view('specialists.education-and-documents', compact('specialist', 'documents'));
    }

    // Метод для отображения счетов и документов оплаты
    public function billingAndPaymentDocuments(Specialist $specialist)
    {
        return view('specialists.billing-and-payment-documents', compact('specialist'));
    }
}
