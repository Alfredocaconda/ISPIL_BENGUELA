<?php

namespace App\Http\Controllers;

use App\Models\funcionario;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FuncionarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $valor=Funcionario::orderBy('name','asc')->get();
        return view("pages.secretaria.funcionario",compact("valor"));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $valor=null;
        if(isset($request->id)){
            $valor= Funcionario::find($request->id);
        }else{

            $valor= new Funcionario();
            $user  = User::cadastrarFuncionario($request);
            $valor->user_id=$user->id;
        }
        $valor->nome=$request->nome;
        $valor->cargo=$request->cargo;
        $valor->telefone=$request->telefone;
        $valor->email=$request->email;
        $valor->data_contratacao=$request->data_contratacao;
        $valor->save();
        return redirect()->back()->with("SUCESSO","FUNCIONARIO CADASTRADO");
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        //
        $valor=Funcionario::find($id);
        return view("pages.Funcionario",compact("valor"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function apagar( $id)
    {
        //
        Funcionario::find($id)->delete();
        return redirect()->back()->with("SUCESSO","FUNCIONARIO ELIMINADO");
    }
}
