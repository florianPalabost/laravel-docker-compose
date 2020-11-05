<?php

namespace App\Http\Controllers;

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
        if ($request->get('property') === '') {
            throw new \Error('no property pass');
        }

        // check property if enum : like, watch, want_to_watch
        $property = $request->get('property');
        if ($property === 'like' || $property === 'watch' || $property === 'want_to_watch') {
            $user = auth()->user();
            if (!empty($request->get('anime_id')) && !empty($user)) {
                $animeId = $request->get('anime_id');
                if($this->animeService->saveUserAnimeStatus($animeId, $user->id, $property)) {
                    return \response()->json(['message'=> 'property updated'],201);
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
