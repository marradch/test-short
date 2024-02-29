<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLinkRequest;
use Illuminate\Http\JsonResponse;
use App\Services\Shortener;
use App\Models\Link;
use Illuminate\Http\RedirectResponse;

class LinksController extends Controller
{
    public function create(CreateLinkRequest $request): JsonResponse
    {
        $short = (new Shortener())->make($request->link);

        return response()->json([
            'short' => $short,
        ]);
    }

    public function goToLink(string $short): RedirectResponse
    {
        $link = Link::query()->where('short', $short)->first();
        if (!$link) {
            throw new \Exception('Short not found');
        }

        return redirect($link->link);
    }
}
