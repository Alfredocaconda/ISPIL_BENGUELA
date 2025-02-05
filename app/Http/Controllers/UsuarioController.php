<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Candidato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use User as GlobalUser;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function auth(Request $request){
        $user = user::where('email', $request->email)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['AS CREDENÇIAS INSERIDAS ESTÃO ERRADAS.'],
            ]);
        }
       Auth::login($user,$remember = true);
       if(Auth::user()->tipo != 'candidato'){
           return redirect('login');
       }else{
            return redirect()->route('candidato.index');
       }
    }
    public function index()
    {
        //
        //$usuario=user::all();
        //return view("pages.estudante.index",compact("usuario"));
        
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
            $valor= user::find($request->id);
        } else {
            # code...
            $valor= new user();
        }
        
        $valor->name=$request->nome;
        $valor->email=$request->email;
        $valor->password=bcryp($request->password);
        $valor->tipo=$request->tipo;
        $valor->save();
        return redirect()->back()->with("Sucesso","Usuario cadastrado com sucesso");
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $valor=user::find($id);
        return redirect()->route('user.index');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function apagar($id)
    {
        user::find($id)->delete();
        $sms = "ESTUDANTE Eliminado com sucesso";
        return redirect()->back()->with("Sucesso",$sms);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function cadastrar(Request $request){
      
            $user = User::cadastrarCandidato($request);
            if(User::entrar($request)){
                return redirect()->route('candidato.index');
            }else{
                return redirect()->route('auth.login');
            }
    }
    public function perfil(){
       # return view('pages.perfil.perfil');
   }
}
