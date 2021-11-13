<?php

namespace App\Mail\Mailing;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BasicMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $title;
    public $body;
    public $article;
    public $subtitle;
    public $subject;

    public function __construct($body, $title, $article, $subject= 'Tabigat Media рекомендует к чтению')
    {
        $this->title = $title;
        $this->body = $body;
        $this->article = $article;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.sample-mail', [
            'title' => $this->title ?? $this->article['title'],
            'body' => $this->body,
            'articleUrl' => env('MAIL_BUTTON_REDIRECT_URL') . '/' . $this->article['id'],
            'article' => $this->article,
        ])->subject($this->subject)
            ->from('tabigatmedia@kz.zz');
    }
}
