<?php

namespace App\Mail\notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class likePost extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;
    public $postId;
    public $APP_URL;

    /**
     * Create a new message instance.
     */
    public function __construct($userName, $postId)
    {
        $this->userName = $userName;
        $this->postId = $postId;
        $this->APP_URL = env("APP_URL");
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject:  $this->userName . ", " .'like your post',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.notifications.likePostNotification',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
