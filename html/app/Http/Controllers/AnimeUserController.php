<?php

namespace App\Http\Controllers;

use App\AnimeUser;
use App\Exceptions\PropertyNotFoundException;
use App\Services\AnimeService;
use Illuminate\Http\Request;

class AnimeUserController extends Controller
{
    protected $animeService;

    public function __construct(AnimeService $animeService)
    {
        $this->middleware('auth');
        $this->animeService = $animeService;
    }

    public function recordUserAnimeStatus(Request $request)
    {
        if ($request->json('property') === '') {
            throw new \Error('no property pass');
        }

        $property = $request->json('property');
        // check property if enum : like, watch, want_to_watch
        if ($property === 'like' || $property === 'watch' || $property === 'want_to_watch') {
            $user = auth()->user();
            if (!empty($request->json('anime_id')) && !empty($user)) {
                $animeId = $request->json('anime_id');
                try {
                    /** @var AnimeUser $animeUser */
                    $animeUser = $this->animeService->saveUserAnimeStatus($animeId, $user->id, $property);
                } catch (PropertyNotFoundException $e) {
                    return back()->withErrors($e->getMessage());
                }
                if ($animeUser->wasChanged() || $animeUser->wasRecentlyCreated) {
                    return \response()->json(['data' => $animeUser], 201);
                }
                return \response()->json(['message' => 'cant change property'], 500);
            }
            throw new \Error('no anime id given !');
        }
        throw new \Error($property . ' property is not recorded :');
    }
}
