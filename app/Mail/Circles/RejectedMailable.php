<?php

namespace App\Mail\Circles;

use App\Eloquents\Circle;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RejectedMailable extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $circle;
    public $questions;
    public $answer;
    public $answer_details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Circle $circle, $questions, $answer, $answer_details)
    {
        $this->circle = $circle;
        $this->questions = $questions;
        $this->answer = $answer;
        $this->answer_details = $answer_details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.circles.reject');
    }
}
