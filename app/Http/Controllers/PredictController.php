<?php

namespace App\Http\Controllers;

use App\Enums\StatusCode;
use App\Models\FootballMatch;
use App\Models\PredictResult;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests\GuessRequest;
use Illuminate\Support\Facades\Auth;

class PredictController extends BaseController
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
            ->join('countries as country_2', 'country_2.id', '=', 'football_matchs.country_2')
            ->where('match_day', '>=', Carbon::now())
            ->with([
                'predictUser' => function ($q) {
                    $q->where('user_id', Auth::guard('admin')->user()->id);
                }
            ]);
        $matchs = $userBuilder->sortable(['match_day' => 'asc'])
            ->select(['football_matchs.*', 'country_1.name as country_1_name', 'country_2.name as country_2_name'])->paginate($newSizeLimit);
        if ($this->checkPaginatorList($matchs)) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $matchs = $userBuilder->paginate($newSizeLimit);
        }
        return view('admin.predict.index', [
            'title' => 'Match List',
            'breadcrumbs' => $breadcrumbs,
            'matchs' => $matchs,
            'request' => $request,
            'newSizeLimit' => $newSizeLimit
        ]);
    }

    public function result(Request $request)
    {
        $breadcrumbs = [
            'Match List',
        ];
        $newSizeLimit = $this->newListLimit($request);
        $userBuilder = FootballMatch::join('countries as country_1', 'country_1.id', '=', 'football_matchs.country_1')
            ->join('countries as country_2', 'country_2.id', '=', 'football_matchs.country_2')
            ->where('match_day', '<=', Carbon::now())
            ->with([
                'predictUser' => function ($q) {
                    $q->where('user_id', Auth::guard('admin')->user()->id);
                }
            ]);
        $matchs = $userBuilder->sortable(['match_day' => 'asc'])
            ->select(['football_matchs.*', 'country_1.name as country_1_name', 'country_2.name as country_2_name'])->paginate($newSizeLimit);
        if ($this->checkPaginatorList($matchs)) {
            Paginator::currentPageResolver(function () {
                return 1;
            });
            $matchs = $userBuilder->paginate($newSizeLimit);
        }
        return view('admin.predict.result', [
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GuessRequest $request, $id)
    {
        $match = FootballMatch::where([
            ['match_day', '>=', Carbon::now()],
            ['id', $id]
        ])->first();
        if (!$match) {
            return response()->json([
                'message' => 'エラーが発生しました。',
            ], StatusCode::INTERNAL_ERR);
        }
        $predictResult = PredictResult::where([
            ['user_id', Auth::guard('admin')->user()->id],
            ['match_id', $id]
        ])->first();
        if (!$predictResult) {
            $predictResult = new PredictResult();
            $predictResult->user_id = Auth::guard('admin')->user()->id;
            $predictResult->match_id = $id;
        }
        $predictResult->predict = $request->result;
        if (!$predictResult->save()) {
            return response()->json([
                'message' => 'エラーが発生しました。',
            ], StatusCode::INTERNAL_ERR);
        }
        return response()->json([
        ], StatusCode::OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
