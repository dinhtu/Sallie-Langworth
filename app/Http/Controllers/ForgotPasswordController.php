<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\ForgotPassword;
use App\Http\Requests\ForgotPassword as ForgotPasswordRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

class ForgotPasswordController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('forgotPassword.create', [
            'title' => 'パスワード再発行申請',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ForgotPasswordRequest $request)
    {
        $account = User::where('email', $request->email)->first();
        if (!$account) {
            $this->setFlash(__('メールでユーザーを見つけることができません'), 'error');
            return redirect(route('forgot_password.create'));
        }
        $account->reset_password_token = md5($request->email . random_bytes(25) . Carbon::now());
        $account->reset_password_token_expire = Carbon::now()->addMinutes(env('FORGOT_PASS_EXPIRED', 30));
        if (!$account->save()) {
            $this->setFlash(__('メールが一致しません'), 'error');
        }
        $mailContents = [
            'data' => [
                'name' => $account->name,
                'link' => route('password_reset.show', $account->reset_password_token)
            ]
        ];
        Mail::to($account->email)->send(new ForgotPassword($mailContents));
        return redirect(route('forgot_password_complete.index'));
    }
}
