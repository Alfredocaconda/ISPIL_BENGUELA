<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MeuEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $dados;

    public function __construct($dados)
    {
        $this->dados = $dados;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME')) 
                    ->replyTo($this->dados['email'], $this->dados['name'])
                    ->subject("Contactar o ISPIL")
                    ->view('email.meuEmail')
                    ->with(['dados' => $this->dados]);
    }
}
