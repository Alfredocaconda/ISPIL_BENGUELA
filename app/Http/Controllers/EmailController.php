<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MeuEmail;
class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        // Validação dos dados do formulário
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        // Dados do formulário
        $dados = $request->only(['nome','email']);

        // Enviar o e-mail para você
        Mail::to('alfredocaconda3@gmail.com')->send(new MeuEmail($dados));

        return redirect()->back()->with('success', 'E-mail enviado com sucesso!');
    }
}
