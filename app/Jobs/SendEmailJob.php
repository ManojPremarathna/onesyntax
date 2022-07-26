<?php

namespace App\Jobs;

use App\Mail\NewPostEmail;
use App\Models\EmailLog;
use App\Models\Post;
use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $subscriber;
    protected $post;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Subscriber $subscriber, Post $post)
    {
        $this->subscriber = $subscriber;
        $this->post       = $post;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // check if already sent
        if(
            !EmailLog::where('subscriber_id', '=', $this->subscriber->id)
                ->where('post_id', '=', $this->post->id)
                ->exists()
        ) {
            $email = new NewPostEmail($this->post);
            Mail::to($this->subscriber->email)->send($email);

            // update email log
            $mailLog = new EmailLog();
            $mailLog->subscriber_id = $this->subscriber->id;
            $mailLog->post_id       = $this->post->id;
            $mailLog->save();
        }
    }
}
