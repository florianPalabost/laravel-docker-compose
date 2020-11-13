<?php

namespace App\Http\Controllers;

use App\AnimeUser;
use App\Services\AnimeService;
use http\Env\Response;
use Illuminate\Http\Request;

class AnimeUserController extends Controller
{
    protected $animeService;

    public function __construct(AnimeService $animeService)
    {
        $this->middleware('auth');
        $this->animeService = $animeService;
    }

    public function recordUserAnimeStatus(Request $request) {
        if ($request->json('property') === '') {
            throw new \Error('no property pass');
        }

        // check property if enum : like, watch, want_to_watch
        $property = $request->json('property');
        if ($property === 'like' || $property === 'watch' || $property === 'want_to_watch') {
            $user = auth()->user();
            if (!empty($request->json('anime_id')) && !empty($user)) {
                $animeId = $request->json('anime_id');

                /** @var AnimeUser $animeUser */
                $animeUser = $this->animeService->saveUserAnimeStatus($animeId, $user->id, $property);
                if($animeUser->wasChanged() || $animeUser->wasRecentlyCreated) {
                    return \response()->json(['data'=> $animeUser],201);
                }
                else {
                    return \response()->json(['message'=> 'cant change property'], 500);
                }
            }
            else {
                throw new \Error('no anime id given !');
            }

        }
        else {
            throw new \Error($property . ' property is not recorded :');
        }
    }
}
