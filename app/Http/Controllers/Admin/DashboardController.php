<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\FootballMatch;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class DashboardController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $footballMatchs = FootballMatch::where('match_day', '<=', Carbon::now())->with(['predictResults'])->get();
        $users = User::where('id', '<>', 1)->orderBy('name')->get();
        $userNames = [];
        $money = [];
        foreach ($users as $key => $value) {
            $userNames[$value->id] = $value->name;
            $money[$value->id] = 0;
        }
        foreach ($footballMatchs as $footballMatch) {
            if (!$footballMatch->result) {
                continue;
            }
            foreach ($users as $user) {
                $userPredict = $footballMatch->predictResults->where('user_id', $user->id)->first();
                if (!$userPredict || $footballMatch->result != $userPredict->predict) {
                    $money[$user->id] += $footballMatch->knockout ? env('MONEY_KNOCKOUT') : env('MONEY_NORMAL');
                }
            }
        }
        return view('admin.dashboard.index', [
            'title' => 'ホー1ム',
            'userNames' => array_values($userNames),
            'money' => array_values($money)
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
    public function update(Request $request, $id)
    {
        //
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
