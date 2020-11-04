<?php

namespace App\Http\Controllers;

use App\Anime;
use App\Services\AnimeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    private $animeService;
    public function __construct(AnimeService $animeService)
    {
        $this->middleware('auth');
        $this->animeService = $animeService;
    }

    public function dashboard(Request $request) {
        if ($request->ajax()) {
            $data = DB::table('animes')->whereNotNull('title')->latest()->get();
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

        return view('users.dashboard', compact('animes'));
    }

    public function profile() {
        return view('users.profile');
    }
}
