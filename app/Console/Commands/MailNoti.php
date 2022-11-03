<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Mail\SendNoti;
use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Command;

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
        $users = User::get();
        foreach ($users as $key => $user) {
            Mail::to($user->email)->send(new SendNoti(['name' => $user->name]));
        }
    }
}
