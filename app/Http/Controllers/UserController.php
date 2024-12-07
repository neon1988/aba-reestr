<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserPhotoRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\CenterResource;
use App\Http\Resources\UserResource;
use App\Models\Image;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::orderBy('name', 'asc')->paginate(9)
            ->withQueryString();

        $users->load('photo');

        return UserResource::collection($users);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): UserResource
    {
        $user->load('photo');
        return new UserResource($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $this->authorize('update', $user);

        $user->fill($request->validated());
        $user->save();

        if ($request->hasFile('photo'))
        {
            if ($user->photo instanceof Image)
                $user->photo->delete();

            $photo = new Image;
            $photo->openImage($request->file('photo')->getRealPath());
            $photo->storage = config('filesystems.default');
            $photo->name = $request->file('photo')->getClientOriginalName();
            $photo->save();

            $user->photo_id = $photo->id;
            $user->save();
        }

        $user->load('photo');

        return response()
            ->json([
                'user' => new UserResource($user),
                'message' => 'Данные пользователя сохранены'
            ]);
    }

    public function updatePhoto(UpdateUserPhotoRequest $request, User $user): JsonResponse
    {
        if ($user->photo instanceof Image)
            $user->photo->delete();

        $photo = new Image;
        $photo->openImage($request->file('photo')->getRealPath());
        $photo->storage = config('filesystems.default');
        $photo->name = $request->file('photo')->getClientOriginalName();
        $photo->save();

        $user->photo_id = $photo->id;
        $user->save();
        $user->load('photo');

        return response()
            ->json([
                'user' => new UserResource($user),
                'message' => 'Фотография обновлена'
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


}
