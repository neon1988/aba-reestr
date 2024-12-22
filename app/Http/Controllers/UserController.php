<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserEmailRequest;
use App\Http\Requests\UpdateUserPhotoRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Image;
use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::search($request->input('search'))
            ->paginate(9)
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
    public function show(Request $request, User $user): Factory|View|Application|UserResource
    {
        $user->load('photo');

        if ($request->expectsJson())
            return new UserResource($user);
        else
            return view('users.show', compact('user'));
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
        $this->authorize('update', $user);

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

    // Отображение формы для смены почты
    public function showChangeEmailForm()
    {
        return view('users.change-email');
    }

    // Обработка смены почты
    public function changeEmail(UpdateUserEmailRequest $request)
    {
        // Валидация данных
        $validated = $request->validated();

        // Проверка текущего пароля пользователя
        if (!Hash::check($validated['current_password'], Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Неверный текущий пароль']);
        }

        // Обновление почты пользователя
        $user = Auth::user();
        $user->email = $validated['email'];
        $user->email_verified_at = null;
        $user->save();

        // Отправка уведомления с подтверждением нового email
        $user->notify(new VerifyEmail());

        return back()->with('success', 'Почта обновлена, проверьте почту для подтверждения.');
    }

    public function webinars(User $user)
    {
        $upcomingWebinars = $user->webinars()
            ->upcoming()->with('cover')
            ->get();

        $endedWebinars = $user->webinars()
            ->ended()->with('cover')
            ->simplePaginate(10);

        return view('users.webinars', compact('upcomingWebinars', 'endedWebinars'));
    }

    public function updateSubscription(Request $request, User $user)
    {
        $this->authorize('updateSubscription', $user);

        $user->fill($request->validated());
        $user->save();
    }
}
