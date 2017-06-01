<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Mail\Mailer;
use Log;
class SendFriendRequestMail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    public $content = [];
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        Log::info("".print_r($this->content));

         $mailer->raw($this->content['content'], function ($message) {
            $message->from('no-reply@laralearn.io', $this->content['name']);
            $message->to($this->content['to']);
        });

    }
}
