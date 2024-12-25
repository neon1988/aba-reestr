<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\File;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(UpdateUserRequest $request): RedirectResponse|JsonResponse
    {
        $user = Auth::user();

        $user = DB::transaction(function () use ($user, $request) {

            $user->fill($request->validated());
            $user->save();

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

        if ($request->expectsJson())
        {
            return response()->json([
                'status' => 'success',
                'message' => 'Профиль успешно обновлен.',
                'data' => new UserResource($user), // Использование Resource для упорядоченного ответа
            ]);
        }
        else
            return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function passwordChange()
    {
        return view('profile.password_change');
    }
}
