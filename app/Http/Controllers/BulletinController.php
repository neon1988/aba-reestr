<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Http\Requests\StoreBulletinRequest;
use App\Http\Requests\UpdateBulletinRequest;
use App\Http\Resources\BulletinResource;
use App\Models\Bulletin;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class BulletinController extends Controller
{
    use AuthorizesRequests;

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
    public function create(): View|Factory|Application
    {
        $this->authorize('create', Bulletin::class);

        return view('bulletins.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBulletinRequest $request)
    {
        $this->authorize('create', Bulletin::class);

        $user = Auth::user();

        $bulletin = Bulletin::make($request->validated());
        $bulletin->creator()->associate(Auth::user());
        $bulletin->status = StatusEnum::OnReview;
        $bulletin->save();

        if ($request->expectsJson())
        {
            return [
                'redirect_to' => route('bulletins.show', compact('bulletin')),
                'bulletin' => new BulletinResource($bulletin)
            ];
        }
        else
            return redirect()->route('bulletins.index')
                ->with('success', 'Объявление успешно добавлено');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Bulletin $bulletin)
    {
        $bulletin->loadMissing('creator.photo');
        if ($request->expectsJson())
            return new BulletinResource($bulletin);
        else
            return redirect()->route('bulletins.show', compact('bulletin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bulletin $bulletin)
    {
        $this->authorize('update', $bulletin);

        return view('bulletins.edit', compact('bulletin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBulletinRequest $request, Bulletin $bulletin)
    {
        $this->authorize('update', $bulletin);

        $bulletin->fill($request->validated());
        $bulletin->save();

        if ($request->expectsJson())
        {
            return [
                'redirect_to' => route('bulletins.show', compact('bulletin')),
                'bulletin' => new BulletinResource($bulletin)
            ];
        }
        else
            return redirect()
                ->route('bulletins.index')
                ->with('success', 'Объявление успешно обновлено');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bulletin $bulletin)
    {
        $this->authorize('delete', $bulletin);

        if ($bulletin->trashed())
            $bulletin->restore();
        else
            $bulletin->delete();

        return new BulletinResource($bulletin);
    }

    /**
     * @throws AuthorizationException
     */
    public function approve(Bulletin $bulletin): JsonResponse
    {
        $this->authorize('approve', $bulletin);

        $bulletin->status = StatusEnum::Accepted;
        $bulletin->save();
        $bulletin->loadMissing('creator.photo');

        Cache::forget('stats.bulletinsCount');
        Cache::forget('stats.bulletinsOnReviewCount');

        return response()
            ->json([
                'bulletin' => new BulletinResource($bulletin),
                'message' => 'Объявление одобрено'
            ]);
    }

    /**
     * @throws AuthorizationException
     */
    public function reject(Bulletin $bulletin): JsonResponse
    {
        $this->authorize('reject', $bulletin);

        $bulletin->status = StatusEnum::Rejected;
        $bulletin->save();
        $bulletin->loadMissing('creator.photo');

        Cache::forget('stats.bulletinsCount');
        Cache::forget('stats.bulletinsOnReviewCount');

        return response()
            ->json([
                'bulletin' => new BulletinResource($bulletin),
                'message' => 'Объявление отклонено'
            ]);
    }
}
