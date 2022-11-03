<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Mail\SendNoti;
use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class MailNoti extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:MailNoti';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::channel('log_batch')->info('start batch MailNoti');
        if (Carbon::now() <= Carbon::parse('2022/11/18') || Carbon::now() > Carbon::parse('2022/12/18')) {
            return;
        }
        $users = User::get();
        foreach ($users as $key => $user) {
            Mail::to($user->email)->send(new SendNoti(['name' => $user->name]));
        }
    }
}
