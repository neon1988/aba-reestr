<?php

namespace App\Http\Controllers;


use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class TagController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $items = Tag::search($request->input('search'))
            ->paginate(9)
            ->withQueryString();

        return TagResource::collection($items);
    }
}
