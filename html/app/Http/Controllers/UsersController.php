<?php

namespace App\Http\Controllers;

use App\Services\AnimeService;
use App\User;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    private $animeService;
    protected $user;

    public function __construct(AnimeService $animeService)
    {
        $this->middleware('auth');
        $this->animeService = $animeService;

        // construct is call before any user is set so we need to pass by a middleware
        // https://laravel.com/docs/5.3/upgrade#5.3-session-in-constructors
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function dashboard(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->animeService->retrieveLatestAnimes();
            try {
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('title', function ($row) {
                        return '<a target="_blank" rel="noreferrer noopenner" href="' . route('animes.show', $row->title) . '">' . $row->title . '</a>';
                    })
                    ->addColumn('action', function ($row) {
                        return '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    })
                    ->rawColumns(['action', 'title'])
                    ->make(true);
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }

        $animes = $this->animeService->retrieveAnimes(false);

        /** @var iterable $statsAnimes */
        $statsAnimes = (object) [
            "like" => 0,
            "watch" => 0,
            "want_to_watch" => 0
        ];

        if (
            (is_array($this->user->animes) || is_object($this->user->animes))
            && isset($this->user->animes) && count($this->user->animes) > 0
        ) {
            foreach ($this->user->animes as $anime) {
                foreach ($statsAnimes as $prop => $count) {
                    if ($anime->stat_anime->$prop) {
                        $statsAnimes->$prop++;
                    }
                }
            }
        }

        return view('users.dashboard', compact('animes', 'statsAnimes'));
    }

    /**
     * @param string $statusProperty = 'like' || 'watch' || 'want_to_watch'
     */
    public function retrieveAnimesUserWithStatus(string $statusProperty)
    {
        if (empty($statusProperty)) {
            throw new \Error('No status provided', 404);
        }
        if ($statusProperty === 'like' || $statusProperty === 'watch' || $statusProperty === 'want_to_watch') {
            $animes = [];
            $title = $statusProperty;
            if (count($this->user->animes) > 0) {
                foreach ($this->user->animes as $anime) {
                    if (isset($anime->stat_anime->$statusProperty) && $anime->stat_anime->$statusProperty) {
                        $animes[] = $anime;
                    }
                }
            }
            return view('animes.index', compact('animes', 'title'));
        }

        throw new \Error('Wrong status given', 404);
    }

    public function profile()
    {
        return view('users.profile');
    }
}
