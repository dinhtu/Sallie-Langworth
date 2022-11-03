<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\InitPassChange;
use App\Mail\ForgotPassComplete;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class PasswordResetController extends BaseController
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($token)
    {
        $account = User::where([
            ['reset_password_token', $token],
            ['reset_password_token_expire', '>=', Carbon::now()]
        ])->first();
        if (!$account) {
            $this->setFlash(__('期限切れのリンク'), 'error');
            return view('passwordResetExpired.index', [
                'title' => 'パスワード再設定期限外',
            ]);
        }
        return view('passwordReset.show', [
            'title' => 'パスワード再設定',
            'token' => $token,
        ]);
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
        $account = User::where([
            ['reset_password_token', $id],
            ['reset_password_token_expire', '>=', Carbon::now()]
        ])->first();
        if (!$account) {
            $this->setFlash(__('期限切れのリンク'), 'error');
            return view('passwordResetExpired.index', [
                'title' => 'パスワード再設定期限外',
            ]);
        }
        $account->password = Hash::make($request->password);
        $account->reset_password_token = null;
        if ($account->save()) {
            $mailContents = [
                'name' => $account->name,
                'mail' => $account->email,
            ];
            Mail::to($account->email)->send(new ForgotPassComplete($mailContents));
            $this->setFlash(__('パスワード変更が完了しました'));
            return redirect()->route('login.index');
        }
        $this->setFlash(__('期限切れのリンク'), 'error');
        return view('passwordResetExpired.index', [
            'title' => 'パスワード再設定期限外',
        ]);
    }
}
