<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\Candidato;

class CandidatoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $usuario = Candidato::all();
        $cursos = Curso::all();
        
        return view("pages.candidato.index", compact('usuario', 'cursos'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $candidato = null;
        
        if (isset($request->id)) {
            // Se o ID existir, busca o candidato
            $candidato = Candidato::find($request->id);
        } else {
            // Cria um novo usuário e associa ao candidato
            $user = User::cadastrarCandidato($request);
            $candidato = new Candidato();
            $candidato->user_id = $user->id;
        }
        
        // Atualiza os dados do candidato
        $candidato->name = $request->name;
        $candidato->email = $request->email;
        $candidato->password = bcrypt($request->password);
        $candidato->tipo = "Candidato";
        $candidato->save();
    
        return redirect()->route('login')->with("Sucesso", "Usuário cadastrado com sucesso. Faça login para continuar.");
    }
    


    /**
     * Display the specified resource.
     */
    public function show(Candidato $candidato)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Candidato $candidato)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Candidato $candidato)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Candidato $candidato)
    {
        //
    }
}
