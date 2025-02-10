<?php

namespace App\Http\Controllers;

use App\Models\matricula;
use Illuminate\Http\Request;

class MatriculaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $valor=matricula::all();
        return view('pages.estudante.matricula',compact('valor'));
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
    public function show(matricula $matricula)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(matricula $matricula)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, matricula $matricula)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(matricula $matricula)
    {
        //
    }
}
