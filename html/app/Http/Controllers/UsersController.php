<?php

namespace App\Http\Controllers;

use App\Services\AnimeService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    private $animeService;
    protected $user;

    public function __construct(AnimeService $animeService)
    {
        $this->middleware('auth');
        $this->animeService = $animeService;
        $this->user = auth()->user();
    }

    public function dashboard(Request $request) {
        if ($request->ajax()) {
            $data = $this->animeService->retrieveLatestAnimes();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('title', function($row) {
                    return '<a target="_blank" rel="noreferrer noopenner" href="'.route('animes.show', $row->title).'">' . $row->title . '</a>';
                })
                ->addColumn('action', function($row){
                    return '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                })
                ->rawColumns(['action', 'title'])
                ->make(true);
        }

        $animes = $this->animeService->retrieveAnimes(false);

        $statsAnimes = (object) [
            "like" => 0,
            "watch" => 0,
            "want_to_watch" => 0
        ];
        if(isset($this->user->animes) && count($this->user->animes) > 0) {
            foreach ($this->user->animes as $anime) {
                foreach ($statsAnimes as $prop => $count) {
                    if ($anime->stat_anime->$prop) $statsAnimes->$prop++;
                }
            }
        }

        return view('users.dashboard', compact('animes', 'statsAnimes'));
    }

    public function profile() {
        return view('users.profile');
    }
}
