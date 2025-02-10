<?php

namespace App\Http\Controllers;

use App\Models\reconfirmacao;
use Illuminate\Http\Request;

class ReconfirmacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $valor=reconfirmacao::all();
        return view('pages.estudante.reconfirmacao',compact('valor'));
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
    public function show(reconfirmacao $reconfirmacao)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(reconfirmacao $reconfirmacao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, reconfirmacao $reconfirmacao)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(reconfirmacao $reconfirmacao)
    {
        //
    }
}
