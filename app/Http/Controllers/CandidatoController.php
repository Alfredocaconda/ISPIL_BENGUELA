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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $valor=null;
        $user = null;
        if (isset($request->id)) {
            # code...
            $valor= Candidato::find($request->id);
        } else {
            # code...
            
            $user  = User::cadastrarCandidato($request);
            $valor= new Candidato();
            $valor->user_id=$user->id;
        }
        
        $valor->name=$request->name;
        $valor->email=$request->email;
        $valor->password=bcryp($request->password);
        $valor->tipo=$request->name;
        $valor->save();
        return redirect()->back()->with("Sucesso","Usuario cadastrado com sucesso");
    
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
