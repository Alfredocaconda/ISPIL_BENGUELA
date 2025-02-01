<?php

namespace App\Http\Controllers;

use App\Models\cadastro;
use Illuminate\Http\Request;

class CadastroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function auth(Request $request){
        $user = User::where('email', $request->email)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['As Credencias inseridas estão erradas'],
            ]);
        }
       Auth::login($user,$remember = true);
       if(Auth::user()->tipo != 'Cadastro'){
           return redirect('/');
       }else{
            return redirect()->route('Cadastro.index');
       }
    }
    public function index()
    {
        //
        $valor=cadastro::all();
        return view('pages.estudante.cadastro',compact('valor'));
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
    }

    /**
     * Display the specified resource.
     */
    public function show(cadastro $cadastro)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(cadastro $cadastro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, cadastro $cadastro)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(cadastro $cadastro)
    {
        //
    }
}
