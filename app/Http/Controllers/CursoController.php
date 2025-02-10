<?php

namespace App\Http\Controllers;

use App\Models\curso;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $valor=curso::all();
        return view('pages.secretaria.cursos',compact('valor'));
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
    public function show(curso $curso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(curso $curso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, curso $curso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(curso $curso)
    {
        //
    }
}
