<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class QrCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $qrContent;
    public $qrFilePath;
    public $qrFileName;

    /**
     * Create a new message instance.
     */
    public function __construct($content, $filePath, $fileName)
    {
        $this->qrContent = $content;
        $this->qrFilePath = $filePath;
        $this->qrFileName = $fileName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Codi QR - La Salle Mollerussa',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.qr-code',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            \Illuminate\Mail\Mailables\Attachment::fromPath($this->qrFilePath)
                ->as($this->qrFileName)
                ->withMime('image/png'),
        ];
    }
}
