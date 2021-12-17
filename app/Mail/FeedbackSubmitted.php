<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FeedbackSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $full_name;

    public $email;

    public $type;

    public $message;

    public function __construct(array $data)
    {
        $this->full_name = $data['full_name'] ?? '';
        $this->email = $data['email'] ?? '';
        $this->type = $data['type'] ?? '';
        $this->message = $data['message'] ?? '';

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.feedback-data', [
            'full_name' => $this->full_name,
            'email' => $this->email,
            'type' => $this->type,
            'msg' => $this->message
        ])->subject('Новый запрос на обратную связь')
            ->from('tabigatmedia@kz.zz');
    }
}
