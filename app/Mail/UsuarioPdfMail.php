<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UsuarioPdfMail extends Mailable
{
    use Queueable, SerializesModels;

    // Criando o construtor para receber o caminho do PDF e o usuário
    public function __construct(public $pdfPath, public $usuario) {}

    // Define o assunto do email
    public function envelope(): Envelope
    {
        return new Envelope(

            // Titulo do email
            subject: 'Relatório de Usuários - PDF',
        );
    }

    // Define o conteúdo do email
    public function content(): Content
    {
        // Define a view para o corpo do email
        return new Content(

            // Define os arquivos modelo de email em HTML e texto simples
            // Pasta emails dentro de resources/views
            view: 'emails.usuario-report',
            text: 'emails.usuario-report-text',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */

    // Anexando o PDF ao email
    public function attachments(): array
    {
        return [
            Attachment::fromPath($this->pdfPath),
        ];
    }
}
