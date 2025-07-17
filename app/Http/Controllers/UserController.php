<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserEmailRequest;
use App\Http\Requests\UpdateUserPhotoRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\File;
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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = trim($request->input('search', '') ?? '');

        $users = User::search($search)
            ->orderBy('created_at', 'desc')
            ->paginate(9)
            ->withQueryString();

        $users->load('photo');

        return UserResource::collection($users);
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
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $this->authorize('update', $user);

        $user = DB::transaction(function () use ($request, $user) {
            $user->fill($request->validated());

            if ($upload = $request->get('photo')) {
                if ($file = File::find($upload['id'])) {
                    if ($file->storage == 'temp' and Auth::user()->is($file->creator)) {
                        $file->storage = 'public';
                        $file->save();
                        $user->photo_id = $file->id;
                    }
                }
            }
            $user->save();

            return $user;
        });

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
        $this->authorize('viewWebinars', $user);

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

    // Метод для отображения счетов и документов оплаты
    public function billingAndPaymentDocuments(User $user)
    {
        $this->authorize('viewPayments', $user);

        $payments = $user->payments()
            ->orderBy('created_at', 'desc')
            ->simplePaginate();

        return view('users.billing-and-payment-documents',
            compact('payments'));
    }
}
