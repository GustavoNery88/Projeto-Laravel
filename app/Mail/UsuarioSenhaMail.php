<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UsuarioSenhaMail extends Mailable
{
    use Queueable, SerializesModels;

    // Criando o construtor para receber o nome e o email do usuário
    public function __construct(public $nome, public $email, public $senhaGerada)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            // Titulo do email
            subject: 'Senha de Acesso',
        );
    }

    // 
    public function content(): Content
    {
        return new Content(
            // Define os arquivos modelo de email em HTML
            view: 'emails.usuario-senha-report',

            // Passando os dados para a view
            with: ['nome' => $this->nome, 'email' => $this->email, 'senhaGerada' => $this->senhaGerada],
        
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
