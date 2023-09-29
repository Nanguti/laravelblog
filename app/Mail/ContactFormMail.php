<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $name;
    protected $email;
    protected $messageContent;

    /**
     * Create a new message instance.
     */
    public function __construct($name, $email, $messageContent)
    {
        $this->name = $name;
        $this->email = $email;
        $this->messageContent = $messageContent;
    }

    

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Contact Form Submission', // Set your desired email subject here
        );
    }


    /**
     * Get the message content definition.
     */
    public function build()
    {
        return $this
            ->subject('New Contact Form Submission')
            ->view('contact')
            ->with([
                'name' => $this->name,
                'email' => $this->email,
                'messageContent' => $this->messageContent,
            ]);
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
