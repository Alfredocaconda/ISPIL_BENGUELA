<?php

namespace App\Http\Controllers;

use App\Models\usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function auth(Request $request){
        $user = usuario::where('email', $request->email)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['AS CREDENÇIAS INSERIDAS ESTÃO ERRADAS.'],
            ]);
        }
       Auth::login($user,$remember = true);
       if(Auth::usuario()->tipo != 'estudante'){
           return redirect('/');
       }else{
            return redirect()->route('estudante.index');
       }
    }
    public function index()
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
        if (isset($request->id)) {
            # code...
            $valor= usuario::find($request->id);
        } else {
            # code...
            $valor= new usuario();
        }
        $valor->nome=$request->nome;
        $valor->nbi=$request->nbi;
        $valor->telefone=$request->telefone;
        $valor->email=$request->email;
        $valor->data_nascimento=$request->data_nascimento;
        $valor->password=$request->password;
        $valor->tipo='estudante';
        $valor->save();
        return redirect()->back()->with("Sucesso");
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $valor=usuario::find($id);
        return view("pages.estudante",compact("valor"));
    }
    /**
     * Remove the specified resource from storage.
     */
    public function apagar($id)
    {
        usuario::find($id)->delete();
        $sms = "ESTUDANTE Eliminado com sucesso";
        return redirect()->back()->with("Sucesso",$sms);
    }
    public function perfil(){
       # return view('pages.perfil.perfil');
   }
}
