<?php

namespace App\Http\Controllers;

use App\Http\Requests\MatchFormRequest;
use App\Enums\StatusCode;
use App\Models\FootballMatch;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Requests\GuessRequest;

class MatchController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $breadcrumbs = [
            'Match List',
        ];
        $newSizeLimit = $this->newListLimit($request);
        $userBuilder = FootballMatch::join('countries as country_1', 'country_1.id', '=', 'football_matchs.country_1')
            ->join('countries as country_2', 'country_2.id', '=', 'football_matchs.country_2');
        $matchs = $userBuilder->sortable(['created_at' => 'desc'])
            ->select(['football_matchs.*', 'country_1.name as country_1_name', 'country_2.name as country_2_name'])->paginate($newSizeLimit);
        if ($this->checkPaginatorList($matchs)) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $matchs = $userBuilder->paginate($newSizeLimit);
        }
        return view('admin.match.index', [
            'title' => 'Match List',
            'breadcrumbs' => $breadcrumbs,
            'matchs' => $matchs,
            'request' => $request,
            'newSizeLimit' => $newSizeLimit
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = [
            [
                'url' => route('match.index'),
                'name' => 'Match List',
            ],
            'Match Create'
        ];
        return view('admin.match.create', [
            'title' => 'Match Create',
            'breadcrumbs' => $breadcrumbs,
            'countries' => Country::get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MatchFormRequest $request)
    {
        $match = new FootballMatch();
        $match->match_day = $request->match_day;
        $match->country_1 = $request->country_1;
        $match->country_2 = $request->country_2;
        $match->knockout = $request->knockout ?? 0;
        $this->setFlash(__('エラーが発生しました。'), 'error');
        if ($match->save()) {
            $this->setFlash(__('success'));
        }
        return redirect()->route('match.index');
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateGuess(GuessRequest $request, $id)
    {
        $match = FootballMatch::where('id', $id)->first();
        if (!$match) {
            return response()->json([
                'message' => 'エラーが発生しました。',
            ], StatusCode::INTERNAL_ERR);
        }
        $match->result = $request->result;
        if (!$match->save()) {
            return response()->json([
                'message' => 'エラーが発生しました。',
            ], StatusCode::INTERNAL_ERR);
        }
        return response()->json([
        ], StatusCode::OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $match = FootballMatch::where('id', $id)->first();
        if (!$match) {
            return redirect()->route('match.index');
        }
        $breadcrumbs = [
            [
                'url' => route('match.index'),
                'name' => 'Match List',
            ],
            'Match Create'
        ];
        return view('admin.match.edit', [
            'title' => 'Match Edit',
            'breadcrumbs' => $breadcrumbs,
            'match' => $match,
            'countries' => Country::get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MatchFormRequest $request, $id)
    {
        $match = FootballMatch::where('id', $id)->first();
        if (!$match) {
            return redirect()->route('match.index');
        }
        $match->match_day = $request->match_day;
        $match->country_1 = $request->country_1;
        $match->country_2 = $request->country_2;
        $match->knockout = $request->knockout ?? 0;
        $this->setFlash(__('エラーが発生しました。'), 'error');
        if ($match->save()) {
            $this->setFlash(__('success'));
        }
        return redirect()->route('match.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $match = FootballMatch::where('id', $id)->first();
        if (!$match) {
            return response()->json([
                'message' => 'エラーが発生しました。',
            ], StatusCode::INTERNAL_ERR);
        }
        if (!$match->delete()) {
            return response()->json([
                'message' => 'エラーが発生しました。',
            ], StatusCode::INTERNAL_ERR);
        }
        return response()->json([
            'message' => 'Delete Success',
        ], StatusCode::OK);
    }
}
